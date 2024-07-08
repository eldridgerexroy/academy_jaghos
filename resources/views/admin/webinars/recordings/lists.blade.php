@extends('admin.layouts.app')

@push('libraries_top')

@endpush

@section('content') 
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ trans('admin/main.webinar_recording') }}</div>
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
                                <a href="{{ getAdminPanelUrl() }}/webinars/webinar_recording/create" class="btn btn-primary">{{ trans('admin/main.add_new') }}</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans('admin/pages/webinars.webinars_recording_webinar') }}</th>
                                            <th>{{ trans('admin/pages/webinars.webinars_recording_date') }}</th>
                                            <th>{{ trans('admin/pages/webinars.webinars_recording_link') }}</th>
                                            <th>{{ trans('admin/pages/webinars.webinars_recording_created_at') }}</th>
                                            <th>{{ trans('admin/pages/webinars.webinars_recording_actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($webinars_recordings as $webinars_recording)
                                            <tr>
                                                <td>{{ $webinars_recording->id }}</td>
                                                <td>{{ $webinars_recording->webinar_name }}</td>
                                                <td>{{ $webinars_recording->date }}</td>
                                                <td class="text-left"><a href="{{ $webinars_recording->link }}">{{ $webinars_recording->link }}</a></td>
                                                <td>{{ $webinars_recording->created_at }}</td>
                                                <td>
                                                    <!-- <a href="{{ getAdminPanelUrl() }}/webinars/webinar_recording/{{ $webinars_recording->id }}" class="btn-transparent text-primary">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="{{ getAdminPanelUrl() }}/webinars/webinar_recording/{{ $webinars_recording->id }}/edit" class="btn-transparent text-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a> -->
                                                    @include('admin.includes.delete_button', ['url' => getAdminPanelUrl() . '/webinars/webinar_recording/' . $webinars_recording->id . '/delete'])
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $webinars_recordings->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')

@endpush
