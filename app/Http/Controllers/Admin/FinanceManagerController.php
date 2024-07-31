<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Accounting;
use App\Models\Order;
use App\Models\ReserveMeeting;
use App\Models\Sale;
use App\Models\SaleLog;
use App\Models\Webinar;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class FinanceManagerController extends Controller
{
    public function indexIncome(Request $request){
        $this->authorize('admin_sales_list');

        $query = Sale::whereNull('product_order_id');

        $salesQuery = $this->getSalesFilters($query, $request);

        $sales = $salesQuery->orderBy('created_at', 'desc')
            ->with([
                'buyer',
                'webinar',
                'meeting',
                'subscribe',
                'promotion'
            ])
            ->get();

        foreach ($sales as $sale) {
            $sale = $this->makeTitle($sale);

            if (empty($sale->saleLog)) {
                SaleLog::create([
                    'sale_id' => $sale->id,
                    'viewed_at' => time()
                ]);
            }
        }

        $totalSales = [
            'count' => deepClone($salesQuery)->count(),
            'amount' => deepClone($salesQuery)->sum('total_amount'),
        ];

        $classesSales = [
            'count' => deepClone($salesQuery)->whereNotNull('webinar_id')->count(),
            'amount' => deepClone($salesQuery)->whereNotNull('webinar_id')->sum('total_amount'),
        ];

        // $appointmentSales = [
        //     'count' => deepClone($salesQuery)->whereNotNull('meeting_id')->count(),
        //     'amount' => deepClone($salesQuery)->whereNotNull('meeting_id')->sum('total_amount'),
        // ];
        $failedSales = Order::where('status', Order::$fail)->count();

        $data = [
            'pageTitle' => trans('admin/pages/financial.income_per_month'),
            'sales' => $sales,
            'totalSales' => $totalSales,
            'classesSales' => $classesSales,
            // 'appointmentSales' => $appointmentSales,
            'failedSales' => $failedSales,
        ];

        // $teacher_ids = $request->get('teacher_ids');
        // $student_ids = $request->get('student_ids');
        // $webinar_ids = $request->get('webinar_ids');

        // if (!empty($teacher_ids)) {
        //     $data['teachers'] = User::select('id', 'full_name')
        //         ->whereIn('id', $teacher_ids)->get();
        // }

        // if (!empty($student_ids)) {
        //     $data['students'] = User::select('id', 'full_name')
        //         ->whereIn('id', $student_ids)->get();
        // }

        // if (!empty($webinar_ids)) {
        //     $data['webinars'] = Webinar::select('id')
        //         ->whereIn('id', $webinar_ids)->get();
        // }

        return view('admin.financial.manager.incomes', $data);
    }

    public function indexExpense(Request $request)
    {
        $this->authorize('admin_sales_list');

        $query = Sale::whereNull('product_order_id');
        
        $salesQuery = $this->getSalesFilters($query, $request);

        $sales = $salesQuery->with([
            'buyer',
            'webinar',
            'meeting',
            'subscribe',
            'promotion'
        ])
        ->get()
        ->groupBy('seller_id')
        ->map(function ($salesGroup, $sellerId) {
            $webinars = $salesGroup->pluck('webinar')->unique('id');
        
            return [
                'seller_id' => $sellerId,
                'total_amount' => $salesGroup->sum('total_amount'),
                'count' => $salesGroup->count(),
                'webinars' => $webinars->map(function ($webinar) {
                    return [
                        'id' => $webinar->id ?? null,
                        'slug' => $webinar->slug ?? null
                    ];
                }),
                'company_share' => $this->calculateCompanyShare($salesGroup->sum('total_amount')),
            ];
        })
        ->sortByDesc('total_amount');

        // Fetch seller names
        $sellerIds = $sales->pluck('seller_id')->toArray();
        $sellers = User::whereIn('id', $sellerIds)->pluck('full_name', 'id')->toArray();
        
        $sales = $sales->map(function ($sale) use ($sellers) {
            $sale['item_seller'] = $sellers[$sale['seller_id']] ?? "Unknown";
            $sale['user_share'] = $sale['total_amount'] - $sale['company_share'];
            return $sale;
        });

        // Calculate total sums
        $totalAmounts = [
            'total_amount' => $sales->sum('total_amount'),
            'company_share' => $sales->sum('company_share'),
            'user_share' => $sales->sum('user_share'),
            'count' => $sales->sum('count'),
        ];

        $totalSales = [
            'count' => $salesQuery->count(),
            'amount' => $salesQuery->sum('total_amount'),
        ];

        $classesSales = [
            'count' => $salesQuery->whereNotNull('webinar_id')->count(),
            'amount' => $salesQuery->whereNotNull('webinar_id')->sum('total_amount'),
        ];

        $failedSales = Order::where('status', Order::$fail)->count();

        $data = [
            'pageTitle' => trans('admin/pages/financial.expense_per_month'),
            'sales' => $sales,
            'totalSales' => $totalSales,
            'classesSales' => $classesSales,
            'failedSales' => $failedSales,
            'totalAmounts' => $totalAmounts
        ];

        return view('admin.financial.manager.expenses', $data);
    }
    
    private function calculateCompanyShare($totalAmount) {
        // NEED TO BE CHANGED IN MASTER DATA LATER ON
        $companySharePercentage = 0.40;
        return $totalAmount * $companySharePercentage;
    }

    private function getSalesFilters($query, $request)
    {
        $month_year = $request->get('month_year');

        if (!empty($item_title)) {
            $ids = Webinar::whereTranslationLike('title', "%$item_title%")->pluck('id')->toArray();
            $webinar_ids = array_merge($webinar_ids, $ids);
        }

        if (!empty($month_year)) {
            list($year, $month) = explode('-', $month_year);
    
            $start_date = Carbon::createFromDate($year, $month, 1)->startOfDay()->timestamp;
            $end_date = Carbon::createFromDate($year, $month, 1)->endOfMonth()->endOfDay()->timestamp;
            $query->whereBetween('created_at', [$start_date, $end_date]);
        } 

        if (!empty($status)) {
            if ($status == 'success') {
                $query->whereNull('refund_at');
            } elseif ($status == 'refund') {
                $query->whereNotNull('refund_at');
            } elseif ($status == 'blocked') {
                $query->where('access_to_purchased_item', false);
            }
        }

        if (!empty($webinar_ids) && count($webinar_ids)) {
            $query->whereIn('webinar_id', $webinar_ids);
        }

        if (!empty($userIds) && count($userIds)) {
            $query->where(function ($query) use ($userIds) {
                $query->whereIn('buyer_id', $userIds);
                $query->orWhereIn('seller_id', $userIds);
            });
        }

        $query->where('refund_at',null);
        $query->orderBy('buyer_id','ASC');

        return $query;
    }

    public function updateAmounts(Request $request)
    {
        $amounts = $request->input('amounts', []);
        foreach ($amounts as $id => $amount) {
            $sale = Sale::find($id);
            if ($sale) {
                $sale->amount = $amount;
                $sale->total_amount = $amount;
                $sale->save();
            }
        }

        return redirect()->back()->with('success', 'Amounts updated successfully.');
    }


    private function makeTitle($sale)
    {
        if (!empty($sale->webinar_id) or !empty($sale->bundle_id)) {
            $item = !empty($sale->webinar_id) ? $sale->webinar : $sale->bundle;

            $sale->item_title = $item ? $item->title : trans('update.deleted_item');
            $sale->item_id = $item ? $item->id : '';
            $sale->item_seller = ($item and $item->creator) ? $item->creator->full_name : trans('update.deleted_item');
            $sale->seller_id = ($item and $item->creator) ? $item->creator->id : '';
            $sale->sale_type = ($item and $item->creator) ? $item->creator->id : '';
        } elseif (!empty($sale->meeting_id)) {
            $sale->item_title = trans('panel.meeting');
            $sale->item_id = $sale->meeting_id;
            $sale->item_seller = ($sale->meeting and $sale->meeting->creator) ? $sale->meeting->creator->full_name : trans('update.deleted_item');
            $sale->seller_id = ($sale->meeting and $sale->meeting->creator) ? $sale->meeting->creator->id : '';
        } elseif (!empty($sale->subscribe_id)) {
            $sale->item_title = !empty($sale->subscribe) ? $sale->subscribe->title : trans('update.deleted_subscribe');
            $sale->item_id = $sale->subscribe_id;
            $sale->item_seller = 'Admin';
            $sale->seller_id = '';
        } elseif (!empty($sale->promotion_id)) {
            $sale->item_title = !empty($sale->promotion) ? $sale->promotion->title : trans('update.deleted_promotion');
            $sale->item_id = $sale->promotion_id;
            $sale->item_seller = 'Admin';
            $sale->seller_id = '';
        } elseif (!empty($sale->registration_package_id)) {
            $sale->item_title = !empty($sale->registrationPackage) ? $sale->registrationPackage->title : 'Deleted registration Package';
            $sale->item_id = $sale->registration_package_id;
            $sale->item_seller = 'Admin';
            $sale->seller_id = '';
        } elseif (!empty($sale->gift_id) and !empty($sale->gift)) {
            $gift = $sale->gift;
            $item = !empty($gift->webinar_id) ? $gift->webinar : (!empty($gift->bundle_id) ? $gift->bundle : $gift->product);

            $sale->item_title = $gift->getItemTitle();
            $sale->item_id = $item->id;
            $sale->item_seller = $item->creator->full_name;
            $sale->seller_id = $item->creator_id;
        } elseif (!empty($sale->installment_payment_id) and !empty($sale->installmentOrderPayment)) {
            $installmentOrderPayment = $sale->installmentOrderPayment;
            $installmentOrder = $installmentOrderPayment->installmentOrder;
            $installmentItem = $installmentOrder->getItem();

            $sale->item_title = !empty($installmentItem) ? $installmentItem->title : '--';
            $sale->item_id = !empty($installmentItem) ? $installmentItem->id : '--';
            $sale->item_seller = !empty($installmentItem) ? $installmentItem->creator->full_name : '--';
            $sale->seller_id = !empty($installmentItem) ? $installmentItem->creator->id : '--';
        } else {
            $sale->item_title = '---';
            $sale->item_id = '---';
            $sale->item_seller = '---';
            $sale->seller_id = '';
        }

        return $sale;
    }
}
