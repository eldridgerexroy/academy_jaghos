@extends('admin.layouts.app')

@push('libraries_top')
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ !empty($request_recording) ? trans('admin/main.edit') : trans('admin/main.new') }} {{ trans('admin/main.request_recording') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}/webinars/request_recording">{{ trans('admin/main.request_recording') }}</a></div>
                <div class="breadcrumb-item">{{ !empty($request_recording) ? trans('admin/main.edit') : trans('admin/main.new') }}</div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ getAdminPanelUrl() }}/webinars/request_recording/{{ !empty($request_recording) ? $request_recording->id.'/update' : 'store' }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group @error('requester') is-invalid @enderror">
                                            <label>{{ trans('admin/pages/webinars.webinars_recording_request_requester') }}</label>
                                            <input type="text" name="requester" class="form-control" value="{{ !empty($request_recording) ? $request_recording->requester : old('requester') }}" placeholder=""/>
                                            @error('requester')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group @error('reason') is-invalid @enderror">
                                            <label>{{ trans('admin/pages/webinars.webinars_recording_request_reason') }}</label>
                                            <input type="text" name="reason" class="form-control" value="{{ !empty($request_recording) ? $request_recording->reason : old('reason') }}" placeholder=""/>
                                            @error('reason')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group @error('email') is-invalid @enderror">
                                            <label>{{ trans('admin/pages/webinars.webinars_recording_request_email') }} </label>
                                            <input type="email" name="email" class="form-control" value="{{ !empty($request_recording) ? $request_recording->email : old('email') }}" placeholder=""/>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group @error('webinar_id') is-invalid @enderror">
                                            <label>{{ trans('admin/pages/webinars.webinars_recording_request_course') }}</label>
                                            <select name="webinar_id" class="form-control">
                                                <option value="">Select Course</option>
                                                @foreach($webinar_recording as $webinar)
                                                    <option value="{{ $webinar->id }}" {{ !empty($request_recording) && $request_recording->course == $course->id ? 'selected' : '' }}>
                                                        {{ $webinar->slug }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('webinar_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group @error('date') is-invalid @enderror">
                                            <label>{{ trans('admin/pages/webinars.webinars_recording_request_date') }}</label>
                                            <input type="date" name="date" class="form-control" value="{{ !empty($request_recording) ? $request_recording->date : old('date') }}" placeholder=""/>
                                            @error('date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
@endpush
