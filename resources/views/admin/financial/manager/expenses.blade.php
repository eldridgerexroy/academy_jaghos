@extends('admin.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a>
                </div>
                <div class="breadcrumb-item">{{ $pageTitle }}</div>
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
                                <h4>{{ trans('admin/main.total_sales') }}</h4>
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
                            <i class="fas fa-play-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('admin/main.classes_sales') }}</h4>
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
                        <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ trans('admin/main.income') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ handlePrice($totalAmounts['company_share']) }}
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

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped font-14">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th class="text-left">{{ trans('admin/main.teacher') }}</th>
                                                <th>{{ trans('admin/main.item') }}</th>
                                                <th>{{ trans('admin/pages/financial.total_amount') }}</th>
                                                <th>{{ trans('admin/pages/financial.company_share') }}(40%)</th>
                                                <th>{{ trans('admin/pages/financial.user_share') }}(60%)</th>
                                                <th>{{ trans('admin/pages/financial.sales_count') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($sales as $sale)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="text-left">
                                                        {{ $sale['item_seller'] }}
                                                        <div class="text-primary text-small font-600-bold">ID: {{ $sale['seller_id'] }}</div>
                                                    </td>
                                                    <td class="text-left">
                                                        @if(isset($sale['webinars']) && count($sale['webinars']) > 0)
                                                            @foreach($sale['webinars'] as $webinar)
                                                                <div class="webinar-tooltip">
                                                                    {{ $webinar['id'] ?? 'N/A' }}
                                                                    <span class="webinar-tooltiptext">{{ $webinar['slug'] ?? 'N/A' }}</span>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <div>No webinars available</div>
                                                        @endif
                                                    </td>
                                                    <td>{{ handlePrice($sale['total_amount']) }}</td>
                                                    <td><b>{{ handlePrice($sale['company_share']) }}</b></td>
                                                    <td><b>{{ handlePrice($sale['user_share']) }}</b></td>
                                                    <td>{{ $sale['count'] }}</td>
                                                </tr>
                                            @endforeach

                                            <!-- Total Row -->
                                            <tr class="bg-secondary text-white">
                                                <td colspan="3" class="text-center"><strong>{{ trans('admin/pages/financial.total') }}</strong></td>
                                                <td><strong>{{ handlePrice($totalAmounts['total_amount']) }}</strong></td>
                                                <td><strong>{{ handlePrice($totalAmounts['company_share']) }}</strong></td>
                                                <td><strong>{{ handlePrice($totalAmounts['user_share']) }}</strong></td>
                                                <td><strong>{{ $totalAmounts['count'] }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
