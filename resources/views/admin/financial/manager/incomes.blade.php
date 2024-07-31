@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('admin/main.sales') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a>
                </div>
                <div class="breadcrumb-item">{{ trans('admin/main.sales') }}</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row"> 
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{trans('admin/main.total_sales')}}</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalSales['count'] }}
                            </div>
                            <div class="text-primary font-weight-bold">
                                {{ handlePrice($totalSales['amount']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-play-circle"></i></div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{trans('admin/main.classes_sales')}}</h4>
                            </div>
                            <div class="card-body">
                                {{ $classesSales['count'] }}
                            </div>
                            <div class="text-success font-weight-bold">
                                {{ handlePrice($classesSales['amount']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-times"></i></div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{trans('admin/main.faild_sales')}}</h4>
                            </div>
                            <div class="card-body">
                                {{ $failedSales }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <section class="card">
                <div class="card-body">
                    <form method="get" class="mb-0">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="input-label">{{ trans('admin/main.month') }}</label>
                                    <div class="input-group">
                                        <input type="month" id="lsmonth" class="text-center form-control" name="month_year" value="{{ request()->get('month_year') }}" placeholder="Month Year">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mt-1">
                                    <label class="input-label mb-4"> </label>
                                    <input type="submit" class="text-center btn btn-primary w-100" value="{{ trans('admin/main.show_results') }}">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>


            <form method="POST" action="{{ route('update-sales-amounts') }}">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                @can('admin_sales_export')
                                    <a href="{{ getAdminPanelUrl() }}/financial/sales/export" class="btn btn-primary">{{ trans('admin/main.export_xls') }}</a>
                                @endcan
                                <button type="submit" class="btn btn-success mx-2" style="float: right;">{{ trans('admin/main.save') }}</button>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped font-14">
                                        <tr>
                                            <th>#</th>
                                            <th class="text-left">{{ trans('admin/main.student') }}</th>
                                            <th class="text-left">{{ trans('admin/main.instructor') }}</th>
                                            <th>{{ trans('admin/main.paid_amount') }}</th>
                                            <th class="text-left">{{ trans('admin/main.item') }}</th>
                                            <th>{{ trans('admin/main.sale_type') }}</th>
                                            <th>{{ trans('admin/main.date') }}</th>
                                            <!-- <th>{{ trans('admin/main.status') }}</th> -->
                                            <th width="120">{{ trans('admin/main.actions') }}</th>
                                        </tr>

                                        @foreach($sales as $sale)
                                            <tr>
                                                <td>{{ $sale->id }}</td>
                                                <td class="text-left">
                                                    {{ !empty($sale->buyer) ? $sale->buyer->full_name : '' }}
                                                    <div class="text-primary text-small font-600-bold">ID : {{ !empty($sale->buyer) ? $sale->buyer->id : '' }}</div>
                                                </td>
                                                <td class="text-left">
                                                    {{ $sale->item_seller }}
                                                    <div class="text-primary text-small font-600-bold">ID : {{ $sale->seller_id }}</div>
                                                </td>

                                                <td>
                                                    @if($sale->payment_method == \App\Models\Sale::$subscribe)
                                                        <span class="">{{ trans('admin/main.subscribe') }}</span>
                                                    @else
                                                        <input type="number" class="form-control" name="amounts[{{ $sale->id }}]" value="{{ $sale->total_amount ?? 0 }}" step="100">
                                                    @endif
                                                </td>

                                                <td class="text-left">
                                                    <div class="media-body">
                                                        <div>{{ $sale->item_title }}</div>
                                                        <div class="text-primary text-small font-600-bold">ID : {{ $sale->item_id }}</div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <span class="font-weight-bold">
                                                        @if($sale->type == \App\Models\Sale::$registrationPackage)
                                                            {{ trans('update.registration_package') }}
                                                        @elseif($sale->type == \App\Models\Sale::$product)
                                                            {{ trans('update.product') }}
                                                        @elseif($sale->type == \App\Models\Sale::$bundle)
                                                            {{ trans('update.bundle') }}
                                                        @elseif($sale->type == \App\Models\Sale::$gift)
                                                            {{ trans('update.gift') }}
                                                        @elseif($sale->type == \App\Models\Sale::$installmentPayment)
                                                            {{ trans('update.installment_payment') }}
                                                        @else
                                                            {{ trans('admin/main.'.$sale->type) }}
                                                        @endif
                                                    </span>
                                                </td>

                                                <td>{{ dateTimeFormat($sale->created_at, 'j F Y H:i') }}</td>

                                                <!-- <td>
                                                    @if(!empty($sale->refund_at))
                                                        <span class="text-warning">{{ trans('admin/main.refund') }}</span>
                                                    @elseif(!$sale->access_to_purchased_item)
                                                        <span class="text-danger">{{ trans('update.access_blocked') }}</span>
                                                    @else
                                                        <span class="text-success">{{ trans('admin/main.success') }}</span>
                                                    @endif
                                                </td> -->

                                                <td>
                                                    @can('admin_sales_invoice')
                                                        @if(!empty($sale->webinar_id) or !empty($sale->bundle_id))
                                                            <a href="{{ getAdminPanelUrl() }}/financial/sales/{{ $sale->id }}/invoice" target="_blank" title="{{ trans('admin/main.invoice') }}"><i class="fa fa-print" aria-hidden="true"></i></a>
                                                        @endif
                                                    @endcan

                                                    @can('admin_sales_refund')
                                                        @if(empty($sale->refund_at) and $sale->payment_method != \App\Models\Sale::$subscribe)
                                                            @include('admin.includes.delete_button',[
                                                                    'url' => getAdminPanelUrl().'/financial/sales/'. $sale->id .'/refund',
                                                                    'tooltip' => trans('admin/main.refund'),
                                                                    'btnIcon' => 'fa-times-circle'
                                                                ])
                                                        @endif
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>

                            <div class="card-footer text-center">
                                {{-- {{ $sales->appends(request()->input())->links() }} --}}
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </section>
@endsection

