@extends('admin.layouts.app')

@push('libraries_top')
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ !empty($departments) ? trans('admin/main.edit') : trans('admin/main.new') }} {{ trans('admin/main.departments') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
            <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}/departments">{{ trans('admin/main.departments') }}</a></div>
            <div class="breadcrumb-item">{{ !empty($departments) ? trans('admin/main.edit') : trans('admin/main.new') }}</div>
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
                        <form action="{{ getAdminPanelUrl() }}/departments/{{ !empty($departments) ? $departments->id.'/update' : 'store' }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group @error('name') is-invalid @enderror">
                                        <label>{{ trans('admin/main.name') }}</label>
                                        <input type="text" name="name" class="form-control" value="{{ !empty($departments) ? $departments->name : old('name') }}" placeholder="" />
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('description') is-invalid @enderror">
                                        <label>{{ trans('admin/pages/departments.description') }}</label>
                                        <textarea name="description" class="form-control" placeholder="">{{ !empty($departments) ? $departments->description : old('description') }}</textarea>
                                        @error('description')
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