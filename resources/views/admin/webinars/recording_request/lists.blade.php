@extends('admin.layouts.app')

@push('libraries_top')

@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ trans('admin/main.request_recording') }}</div>
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
                            <div class="float-right">
                                <a href="{{ getAdminPanelUrl() }}/webinars/request_recording/create" class="btn btn-primary">{{ trans('admin/main.add_new') }}</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans('admin/pages/webinars.webinars_recording_request_requester') }}</th>
                                            <th>{{ trans('admin/pages/webinars.webinars_recording_request_reason') }}</th>
                                            <th>{{ trans('admin/pages/webinars.webinars_recording_request_email') }}</th>
                                            <th>{{ trans('admin/pages/webinars.webinars_recording_request_course') }}</th>
                                            <th>{{ trans('admin/pages/webinars.webinars_recording_request_date') }}</th>
                                            <th>{{ trans('admin/pages/webinars.webinars_recording_request_created_at') }}</th>
                                            <th>{{ trans('admin/pages/webinars.webinars_recording_request_actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($webinar_requests as $webinar_recording_request)
                                            <tr>
                                                <td>{{ $webinar_recording_request->id }}</td>
                                                <td class="text-left">{{ $webinar_recording_request->requester }}</td>
                                                <td>{{ $webinar_recording_request->reason }}</td>
                                                <td>{{ $webinar_recording_request->email }}</td>
                                                <td>{{ $webinar_recording_request->webinar_id }}</td>
                                                <td>{{ $webinar_recording_request->date }}</td>
                                                <td>{{ $webinar_recording_request->created_at }}</td>
                                                <td>
                                                    <!-- <a href="{{ getAdminPanelUrl() }}/webinars/request_recording/{{ $webinar_recording_request->id }}" class="btn-transparent text-primary">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="{{ getAdminPanelUrl() }}/webinars/request_recording/{{ $webinar_recording_request->id }}/edit" class="btn-transparent text-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a> -->
                                                    @include('admin.includes.delete_button', ['url' => getAdminPanelUrl() . '/webinars/request_recording/' . $webinar_recording_request->id . '/delete'])
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $webinar_requests->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')

@endpush
