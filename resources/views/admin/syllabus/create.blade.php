@extends('admin.layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ !empty($syllabus) ? trans('admin/main.edit') : trans('admin/main.new') }} {{ $pageTitle }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
            <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}/syllabus/{{$university_major_id}}">{{ trans('admin/main.syllabus') }}</a></div>
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
                            <input type="hidden" name="university_major_id" value="{{$university_major_id}}">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>{{ trans('admin/main.university') }}</label>
                                        <select name="university_id" class="form-control select2">
                                            <option value="{{ $university->id }}" {{ !empty($syllabus) && $syllabus->university_id == $university->id ? 'selected' : '' }}>{{ $university->name }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>{{ trans('admin/main.major') }}</label>
                                        <select name="major_id" class="form-control select2">
                                            <option value="{{ $major->id }}" {{ !empty($syllabus) && $syllabus->major_id == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>{{ trans('admin/main.department') }}</label>
                                        <select name="department_id" class="form-control select2">
                                            <option value="{{ $department->id }}" {{ !empty($syllabus) && $syllabus->department_id == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group @error('title') is-invalid @enderror">
                                        <label>{{ trans('admin/pages/syllabus.syllabus_name') }}</label>
                                        <input type="text" name="title" class="form-control" value="{{ !empty($syllabus) ? $syllabus->title : old('title') }}" placeholder="" />
                                        @error('title')
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

                                    <div class="form-group @error('course_overview') is-invalid @enderror">
                                        <label>{{ trans('admin/pages/syllabus.course_overview') }}</label>
                                        <textarea name="course_overview" class="form-control ckeditor">{{ !empty($syllabus) ? $syllabus->course_overview : old('course_overview') }}</textarea>
                                        @error('course_overview')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('course_objectives') is-invalid @enderror">
                                        <label>{{ trans('admin/pages/syllabus.course_objectives') }}</label>
                                        <textarea name="course_objectives" class="form-control ckeditor">{{ !empty($syllabus) ? $syllabus->course_objectives : old('course_objectives') }}</textarea>
                                        @error('course_objectives')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('grading_policy') is-invalid @enderror">
                                        <label>{{ trans('admin/pages/syllabus.grading_policy') }}</label>
                                        <textarea name="grading_policy" class="form-control ckeditor">{{ !empty($syllabus) ? $syllabus->grading_policy : old('grading_policy') }}</textarea>
                                        @error('grading_policy')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('assignments') is-invalid @enderror">
                                        <label>{{ trans('admin/pages/syllabus.assignments') }}</label>
                                        <textarea name="assignments" class="form-control ckeditor">{{ !empty($syllabus) ? $syllabus->assignments : old('assignments') }}</textarea>
                                        @error('assignments')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('required_readings') is-invalid @enderror">
                                        <label>{{ trans('admin/pages/syllabus.required_readings') }}</label>
                                        <textarea name="required_readings" class="form-control ckeditor">{{ !empty($syllabus) ? $syllabus->required_readings : old('required_readings') }}</textarea>
                                        @error('required_readings')
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
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
        $('.ckeditor').ckeditor();
    });
</script>
@endpush