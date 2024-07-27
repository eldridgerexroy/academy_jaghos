@extends('admin.layouts.app')

@push('libraries_top')
<!-- Add any additional libraries if needed -->
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ $pageTitle }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
            <div class="breadcrumb-item">{{ trans('admin/pages/universities.university_application') }}</div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        Search Filter
                    </div>
                    <div class="card-body">
                        Search Filter
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-right">
                            <a href="{{ getAdminPanelUrl() }}/universities/application/create" class="btn btn-primary">{{ trans('admin/main.add_new') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped font-14">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-left">{{ trans('admin/pages/universities.title') }}</th>
                                        <th>{{ trans('admin/pages/departments.title') }}</th>
                                        <th>{{ trans('admin/pages/majors.title') }}</th>
                                        <th>{{ trans('admin/pages/universities.city') }}</th>
                                        <th>{{ trans('admin/pages/universities.country') }}</th>
                                        <!-- <th>{{ trans('admin/pages/universities.individual_application_quota') }}</th> -->
                                        <th>{{ trans('admin/pages/universities.individual_application_required_documents') }}</th>
                                        <!-- <th>{{ trans('admin/pages/universities.individual_application_quota_transfer') }}</th> -->
                                        <th>{{ trans('admin/pages/universities.english_program') }}</th>
                                        <th>{{ trans('admin/pages/universities.5_graduate_system_can_apply') }}</th>
                                        <th>{{ trans('admin/pages/universities.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($universities as $university)
                                    <tr>
                                        <td>{{ $university->id }}</td>
                                        <td class="text-left"><b>{{ $university->university->name }}</b></td>
                                        <td><b>{{ $university->department->name }}</b></td>
                                        <td><b>{{ $university->major->name }}</b></td>
                                        <td>{{ $university->university->city->name ?? "Not Found" }}</td>
                                        <td>{{ $university->university->country->name ?? "Not Found" }}</td>
                                        <!-- <td>{{ $university->individual_application_quota }}</td> -->
                                        <td>{{ $university->individual_application_required_documents }}</td>
                                        <!-- <td>{{ $university->individual_application_quota_transfer }}</td> -->
                                        <td>{{ $university->english_program == 1 ? "Yes" : "No"}}</td>
                                        <td>{{ $university['5_graduate_system_can_apply'] == 1 ? "Yes" : "No"}}</td>
                                        <td>
                                            <a href="{{ getAdminPanelUrl() }}/universities/application/{{ $university->id }}/edit" class="btn-transparent text-primary">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @include('admin.includes.delete_button', ['url' => getAdminPanelUrl() . '/universities/application/' . $university->id . '/delete'])
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        {{ $universities->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts_bottom')
<!-- Add any additional scripts if needed -->
@endpush