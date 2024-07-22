@extends('admin.layouts.app')

@push('libraries_top')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ trans('admin/main.affiliate_users') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
            <div class="breadcrumb-item">{{ trans('admin/main.affiliate_users') }}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        @can('admin_referrals_export')
                        <div class="text-right">
                            <a href="{{ getAdminPanelUrl() }}/referrals/excel?type=users" class="btn btn-primary">{{ trans('admin/main.export_xls') }}</a>
                        </div>
                        @endcan
                    </div>

                    <div class="card-body">
                        <form id="filters-form" action="{{ url()->current() }}" method="GET">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="filter-container">
                                        <label for="month">Select Month:</label>
                                        <select id="month" name="month" class="form-control my-2">
                                            <option value="0" {{ $selectedMonth == "0" ? 'selected' : '' }}>All Months</option>
                                            <option value="1" {{ $selectedMonth == "1" ? 'selected' : '' }}>January</option>
                                            <option value="2" {{ $selectedMonth == "2" ? 'selected' : '' }}>February</option>
                                            <option value="3" {{ $selectedMonth == "3" ? 'selected' : '' }}>March</option>
                                            <option value="4" {{ $selectedMonth == "4" ? 'selected' : '' }}>April</option>
                                            <option value="5" {{ $selectedMonth == "5" ? 'selected' : '' }}>May</option>
                                            <option value="6" {{ $selectedMonth == "6" ? 'selected' : '' }}>June</option>
                                            <option value="7" {{ $selectedMonth == "7" ? 'selected' : '' }}>July</option>
                                            <option value="8" {{ $selectedMonth == "8" ? 'selected' : '' }}>August</option>
                                            <option value="9" {{ $selectedMonth == "9" ? 'selected' : '' }}>September</option>
                                            <option value="10" {{ $selectedMonth == "10" ? 'selected' : '' }}>October</option>
                                            <option value="11" {{ $selectedMonth == "11" ? 'selected' : '' }}>November</option>
                                            <option value="12" {{ $selectedMonth == "12" ? 'selected' : '' }}>December</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="filter-container">
                                        <label for="year">Select Year:</label>
                                        <select id="year" name="year" class="form-control my-2">
                                            <option value="0" {{ $selectedYear == "0" ? 'selected' : '' }}>All Years</option>
                                            <option value="2024" {{ $selectedYear == "2024" ? 'selected' : '' }}>2024</option>
                                            <option value="2025" {{ $selectedYear == "2025" ? 'selected' : '' }}>2025</option>
                                            <!-- Add more years if needed -->
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>

                        <div id="affiliates-table" class="table-responsive mt-3">
                            <table class="table table-striped font-14">
                                <thead>
                                    <tr>
                                        <th>{{ trans('admin/main.user') }}</th>
                                        <th>{{ trans('admin/main.role') }}</th>
                                        <th>{{ trans('admin/main.referral_code') }}</th>
                                        <th>{{ trans('admin/main.aff_sales_commission') }}</th>
                                        <!-- <th>{{ trans('admin/main.status') }}</th> -->
                                        <th>{{ trans('admin/main.paid_status') }}</th>
                                        <th>{{ trans('admin/main.paid_date') }}</th>
                                        <th>{{ trans('admin/main.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($affiliates as $affiliate)
                                    <tr>
                                        <td>{{ $affiliate->affiliateUser->full_name }}</td>
                                        <td>
                                            @if($affiliate->affiliateUser->isUser())
                                            Student
                                            @elseif($affiliate->affiliateUser->isTeacher())
                                            Teacher
                                            @elseif($affiliate->affiliateUser->isOrganization())
                                            Organization
                                            @elseif($affiliate->affiliateUser->isSponsorAffiliate())
                                            Sponsor 
                                            @endif
                                        </td>
                                        <td>{{ !empty($affiliate->affiliateUser->getUserGroup()) ? $affiliate->affiliateUser->getUserGroup()->name : '-' }}</td>
                                        <td><b>{{ handlePrice($affiliate->amount) }}</b></td>
                                        <!-- <td>{{ $affiliate->affiliateUser->affiliate ? trans('admin/main.yes') : trans('admin/main.no') }}</td> -->
                                        <td>
                                            @if($affiliate->paid_status)
                                                <span class="badge badge-success">Paid</span>
                                            @else
                                                <span class="badge badge-danger">Unpaid</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="view-details" 
                                                    data-toggle="modal" 
                                                    data-target="#affiliateDetailModal"
                                                    data-details='@json($affiliate->affiliateDetail)'
                                                    data-username="{{ $affiliate->affiliateUser->full_name }}"
                                                    style="border:0px; background-color:white">
                                                    
                                                <span class="badge badge-primary">View Details</span>
                                            </button>
                                        </td>
                                        <td>
                                            <a href="{{ getAdminPanelUrl() }}/users/{{ $affiliate->affiliateUser->id }}/edit" class="btn-transparent text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        {{--{{ $affiliates->appends(request()->input())->links() }}--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="card">
    <div class="card-body">
        <div class="section-title ml-0 mt-0 mb-3">
            <h5>{{ trans('admin/main.hints') }}</h5>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="media-body">
                    <div class="text-primary mt-0 mb-1 font-weight-bold">{{ trans('admin/main.registration_income_hint') }}</div>
                    <div class="text-small font-600-bold">{{ trans('admin/main.registration_income_desc') }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="media-body">
                    <div class="text-primary mt-0 mb-1 font-weight-bold">{{ trans('admin/main.aff_sales_commission_hint') }}</div>
                    <div class="text-small font-600-bold">{{ trans('admin/main.aff_sales_commission_desc') }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Detail Modal -->
<div class="modal fade" id="affiliateDetailModal" tabindex="-1" role="dialog" aria-labelledby="affiliateDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="affiliateDetailModalLabel">Affiliate Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Webinar ID</th>
                            <th>Amount</th>
                            <th>Join Date</th>
                            <th>Paid</th>
                            <th>Paid Date</th>
                        </tr>
                    </thead>
                    <tbody id="affiliateDetailTableBody">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts_bottom')
<script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="/assets/default/js/admin/referrals/users.min.js"></script>
@endpush
