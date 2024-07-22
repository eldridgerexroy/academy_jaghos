<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ReferralHistoryExport;
use App\Exports\ReferralUsersExport;
use App\Http\Controllers\Controller;
use App\Models\Accounting;
use App\Models\Affiliate;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;  

class ReferralController extends Controller
{
    public function history($export = false)
    {
        $this->authorize('admin_referrals_history');

        $affiliatesQuery = Affiliate::query();

        $affiliateUsersCount = deepClone($affiliatesQuery)->groupBy('affiliate_user_id')->count();

        $allAffiliateAmounts = Accounting::where('is_affiliate_amount', true)
            ->where('system', false)
            ->sum('amount');

        $allAffiliateCommissionAmounts = Accounting::where('is_affiliate_commission', true)
            ->where('system', false)
            ->sum('amount');

        $affiliates = $affiliatesQuery
            ->with([
                'affiliateUser' => function ($query) {
                    $query->select('id', 'full_name', 'role_id', 'role_name');
                },
                'referredUser' => function ($query) {
                    $query->select('id', 'full_name', 'role_id', 'role_name');
                }
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $data = [
            'pageTitle' => trans('admin/main.referrals_history'),
            'affiliatesCount' => $affiliates->count(),
            'affiliateUsersCount' => $affiliateUsersCount,
            'allAffiliateAmounts' => $allAffiliateAmounts,
            'allAffiliateCommissionAmounts' => $allAffiliateCommissionAmounts,
            'affiliates' => $affiliates,
        ];

        if ($export) {
            return $affiliates;
        }

        return view('admin.referrals.history', $data);
    }

    public function users($export = false)
    {
        $this->authorize('admin_referrals_users');

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $month = request('month', $currentMonth);
        $year = request('year', $currentYear);

        $affiliates = Affiliate::with([
            'affiliateUser' => function ($query) {
                $query->select('id', 'full_name', 'role_id', 'role_name', 'affiliate')
                    ->with(['affiliateCode', 'userGroup']);
            },
        ])
            ->groupBy('affiliate_user_id')
            ->orderBy('created_at', 'desc')
            ->get();
        
        foreach ($affiliates as $affiliate) {
            $userId = $affiliate->affiliate_user_id;
        
            $accountings = Accounting::where('user_id', $userId)
                ->where('is_affiliate_commission', true)
                ->where('system', false)
                ->when($month && $year, function ($query) use ($month, $year) {
                    $query->whereRaw('MONTH(FROM_UNIXTIME(created_at)) = ?', [$month])
                        ->whereRaw('YEAR(FROM_UNIXTIME(created_at)) = ?', [$year]);
                })
                ->get();
        
            $totalAmount = 0;
            $paidCount = 0;
        
            foreach ($accountings as $accounting) {
                $totalAmount += $accounting->amount;
                if (!is_null($accounting->paid_date)) {
                    $paidCount++;
                }
            }
        
            $affiliate->amount = $totalAmount;
            $affiliate->paid_count = $paidCount . "/" . $accountings->count();
            $affiliate->all_paid = ($paidCount == $accountings->count());
        }
            
        $data = [
            'pageTitle' => trans('admin/main.users'),
            'affiliates' => $affiliates,
            'selectedMonth' => $month,
            'selectedYear' => $year
        ];

        if ($export) {
            return $affiliates;
        }

        return view('admin.referrals.users', $data);
    }

    public function getAffiliateDetail(Request $request)
    {
        $this->authorize('admin_referrals_users');

        $userId = $request->input('user_id');
        $month = $request->input('month');
        $year = $request->input('year');

        $records = Accounting::where('user_id', $userId)
            ->where('is_affiliate_commission', true)
            ->where('system', false)
            ->when($month && $year, function ($query) use ($month, $year) {
                $query->whereRaw('MONTH(FROM_UNIXTIME(created_at)) = ?', [$month])
                    ->whereRaw('YEAR(FROM_UNIXTIME(created_at)) = ?', [$year]);
            })
            ->get();

        return response()->json($records);
    }

    public function exportExcel(Request $request)
    {
        $this->authorize('admin_referrals_export');

        $type = $request->get('type', 'history');

        if ($type == 'users') {
            $referrals = $this->users(true);

            $export = new ReferralUsersExport($referrals);
        } else {
            $referrals = $this->history(true);

            $export = new ReferralHistoryExport($referrals);
        }

        return Excel::download($export, 'referrals_' . $type . '.xlsx');
    }

    // custom to get referral status
    public function updatePaidStatus(Request $request)
    {
        $id = $request->input('id');
        $paid_status = $request->input('paid_status');
        $paid_date = $request->input('paid_date');

        $accounting = Accounting::findOrFail($id);

        if ($paid_status === "true") {
            $accounting->paid_date = $paid_date;
        } else {
            $accounting->paid_date = null; 
        }

        $accounting->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Payment status updated successfully.',
            'paid_date' => $accounting->paid_date,
        ]);
    }
}
