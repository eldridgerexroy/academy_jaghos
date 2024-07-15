@extends('admin.layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ !empty($syllabus) ? trans('admin/main.edit') : trans('admin/main.new') }} {{ $pageTitle }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
            <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}/syllabus">{{ trans('admin/main.syllabus') }}</a></div>
            <div class="breadcrumb-item">{{ !empty($syllabus) ? trans('admin/main.edit') : trans('admin/main.new') }}</div>
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
                        <form action="{{ !empty($syllabus) ? getAdminPanelUrl() . '/syllabus/' . $syllabus->id . '/update' : getAdminPanelUrl() . '/syllabus/store' }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin/main.university') }}</label>
                                        <select name="university_id" class="form-control select2">
                                            @foreach($universities as $university)
                                            <option value="{{ $university->id }}" {{ !empty($syllabus) && $syllabus->university_id == $university->id ? 'selected' : '' }}>{{ $university->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>{{ trans('admin/main.major') }}</label>
                                        <select name="major_id" class="form-control select2">
                                            @foreach($majors as $major)
                                            <option value="{{ $major->id }}" {{ !empty($syllabus) && $syllabus->major_id == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group @error('title') is-invalid @enderror">
                                        <label>{{ trans('admin/pages/syllabus.syllabus_name') }}</label>
                                        <input type="text" name="title" class="form-control" value="{{ !empty($syllabus) ? $syllabus->title : old('title') }}" placeholder="" />
                                        @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('description') is-invalid @enderror">
                                        <label>{{ trans('admin/pages/syllabus.description') }}</label>
                                        <input type="text" name="description" class="form-control" value="{{ !empty($syllabus) ? $syllabus->description : old('description') }}" placeholder="" />
                                        @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('year') is-invalid @enderror">
                                        <label>{{ trans('admin/pages/syllabus.year') }}</label>
                                        <input type="number" name="year" class="form-control" value="{{ !empty($syllabus) ? $syllabus->year : old('year') }}" placeholder="" max="2100" />
                                        @error('year')
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
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endpush