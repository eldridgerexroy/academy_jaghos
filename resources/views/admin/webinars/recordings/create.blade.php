@extends('admin.layouts.app')

@push('libraries_top')
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ !empty($request_recording) ? trans('admin/main.edit') : trans('admin/main.new') }} {{ trans('admin/main.webinar_recording') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}/webinars/webinar_recording">{{ trans('admin/main.webinar_recording') }}</a></div>
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
                            <form action="{{ getAdminPanelUrl() }}/webinars/webinar_recording/{{ !empty($request_recording) ? $request_recording->id.'/update' : 'store' }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group @error('link') is-invalid @enderror">
                                            <label>{{ trans('admin/pages/webinars.webinars_recording_link') }}</label>
                                            <input type="text" name="link" class="form-control" value="{{ !empty($request_recording) ? $request_recording->link : old('link') }}" placeholder=""/>
                                            @error('link')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group @error('webinar_id') is-invalid @enderror">
                                            <label>{{ trans('admin/pages/webinars.webinars_recording_webinar') }}</label>
                                            <select name="webinar_id" class="form-control">
                                                <option value="">Select Webinar</option>
                                                @foreach($webinars as $webinar)
                                                    <option value="{{ $webinar->id }}" {{ !empty($request_recording) && $request_recording->webinar_id == $webinar->id ? 'selected' : '' }}>
                                                        {{ $webinar->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('webinar_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group @error('date') is-invalid @enderror">
                                            <label>{{ trans('admin/pages/webinars.webinars_recording_date') }}</label>
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
