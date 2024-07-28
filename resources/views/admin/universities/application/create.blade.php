@extends('admin.layouts.app')

@push('libraries_top')
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ empty($universities) ? trans('admin/main.edit') : trans('admin/main.new') }} {{ trans('admin/pages/universities.university_application') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
            <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}/universities/application">{{ trans('admin/pages/universities.university_application') }}</a></div>
            <div class="breadcrumb-item">{{ empty($universities) ? trans('admin/main.edit') : trans('admin/main.new') }}</div>
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
                        <form action="{{ getAdminPanelUrl() }}/universities/application/{{ empty($universities) ? $university->id.'/update' : 'store' }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row"> 
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group @error('university_id') is-invalid @enderror">
                                        <label>{{ trans('admin/main.university') }}</label>
                                        <select name="university_id" class="form-control select2">
                                            @if(!empty($universities))
                                                <option value="">{{ trans('admin/main.select') }} {{ trans('admin/main.university') }}</option>
                                                @foreach($universities as $university)
                                                <option value="{{ $university->id }}" {{ (empty($universities) && $university->id == old('university_id', $university->university_id)) ? 'selected' : '' }}>
                                                    {{ $university->name }}
                                                </option>
                                                @endforeach
                                            @else
                                                <option selected value="{{ $university->universityMajor }}" {{ (empty($universities) && $university->id == old('university_id', $university->university_id)) ? 'selected' : '' }}>
                                                    {{ $university->universityMajor->university->name }}
                                                </option>
                                            @endif
                                        </select>
                                        @error('university_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('department_id') is-invalid @enderror">
                                        <label>{{ trans('admin/main.department') }}</label>
                                        <select name="department_id" class="form-control select2">
                                            @if(!empty($departments))
                                                <option value="">{{ trans('admin/main.select') }} {{ trans('admin/main.department') }}</option> 
                                                @foreach($departments as $department)
                                                <option value="{{ $department->id }}" {{ (empty($universities) && $department->id == old('department_id', $university->department_id)) ? 'selected' : '' }}>
                                                    {{ $department->name }}
                                                </option>
                                                @endforeach
                                            @else
                                                <option selected value="{{ $university->university_major }}" {{ (empty($universities) && $university->id == old('university_id', $university->university_id)) ? 'selected' : '' }}>
                                                {{ $university->universityMajor->department->name }}
                                                </option>
                                            @endif
                                        </select>
                                        @error('department_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('major_id') is-invalid @enderror">
                                        <label>{{ trans('admin/main.major') }}</label>
                                        <select name="major_id" class="form-control select2">
                                            @if(!empty($majors)) 
                                                <option value="">{{ trans('admin/main.select') }} {{ trans('admin/main.major') }}</option>
                                                @foreach($majors as $major)
                                                <option value="{{ $major->id }}" {{ (empty($universities) && $major->id == old('major_id', $university->major_id)) ? 'selected' : '' }}>
                                                    {{ $major->name }}
                                                </option>
                                                @endforeach
                                            @else
                                                <option selected value="{{ $university->university_major }}" {{ (empty($universities) && $university->id == old('university_id', $university->university_id)) ? 'selected' : '' }}>
                                                {{ $university->universityMajor->major->name }}
                                                </option>
                                            @endif
                                        </select>
                                        @error('major_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- <div class="form-group @error('individual_application_quota') is-invalid @enderror">
                                        <label>{{ trans('admin/pages/universities.individual_application_quota') }}</label>
                                        <input type="number" name="individual_application_quota" class="form-control" value="{{ empty($universities) ? $university->individual_application_quota : old('individual_application_quota') }}" placeholder="" />
                                        @error('individual_application_quota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div> -->

                                    <div class="form-group @error('individual_application_required_documents') is-invalid @enderror">
                                        <label>{{ trans('admin/pages/universities.individual_application_required_documents') }}</label>
                                        <textarea name="individual_application_required_documents" class="form-control" placeholder="">{{ empty($universities) ? $university->individual_application_required_documents : old('individual_application_required_documents') }}</textarea>
                                        @error('individual_application_required_documents')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- <div class="form-group @error('individual_application_quota_transfer') is-invalid @enderror">
                                        <label>{{ trans('admin/pages/universities.individual_application_quota_transfer') }}</label>
                                        <input type="number" name="individual_application_quota_transfer" class="form-control" value="{{ empty($universities) ? $university->individual_application_quota_transfer : old('individual_application_quota_transfer') }}" placeholder="" />
                                        @error('individual_application_quota_transfer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('united_distribution_quota_total') is-invalid @enderror">
                                        <label>{{ trans('admin/pages/universities.united_distribution_quota_total') }}</label>
                                        <input type="number" name="united_distribution_quota_total" class="form-control" value="{{ empty($universities) ? $university->united_distribution_quota_total : old('united_distribution_quota_total') }}" placeholder="" />
                                        @error('united_distribution_quota_total')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div> -->

                                    <!-- <div class="form-group @error('united_distribution_quota_total_s1') is-invalid @enderror">
                                        <label>{{ trans('admin/pages/universities.united_distribution_quota_total_s1') }}</label>
                                        <input type="number" name="united_distribution_quota_total_s1" class="form-control" value="{{ empty($universities) ? $university->united_distribution_quota_total_s1 : old('united_distribution_quota_total_s1') }}" placeholder="" />
                                        @error('united_distribution_quota_total_s1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('united_distribution_quota_total_s2') is-invalid @enderror">
                                        <label>{{ trans('admin/pages/universities.united_distribution_quota_total_s2') }}</label>
                                        <input type="number" name="united_distribution_quota_total_s2" class="form-control" value="{{ empty($universities) ? $university->united_distribution_quota_total_s2 : old('united_distribution_quota_total_s2') }}" placeholder="" />
                                        @error('united_distribution_quota_total_s2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('united_distribution_quota_total_s3') is-invalid @enderror">
                                        <label>{{ trans('admin/pages/universities.united_distribution_quota_total_s3') }}</label>
                                        <input type="number" name="united_distribution_quota_total_s3" class="form-control" value="{{ empty($universities) ? $university->united_distribution_quota_total_s3 : old('united_distribution_quota_total_s3') }}" placeholder="" />
                                        @error('united_distribution_quota_total_s3')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('united_distribution_quota_total_s4') is-invalid @enderror">
                                        <label>{{ trans('admin/pages/universities.united_distribution_quota_total_s4') }}</label>
                                        <input type="number" name="united_distribution_quota_total_s4" class="form-control" value="{{ empty($universities) ? $university->united_distribution_quota_total_s4 : old('united_distribution_quota_total_s4') }}" placeholder="" />
                                        @error('united_distribution_quota_total_s4')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('united_distribution_quota_total_s5') is-invalid @enderror">
                                        <label>{{ trans('admin/pages/universities.united_distribution_quota_total_s5') }}</label>
                                        <input type="number" name="united_distribution_quota_total_s5" class="form-control" value="{{ empty($universities) ? $university->united_distribution_quota_total_s5 : old('united_distribution_quota_total_s5') }}" placeholder="" />
                                        @error('united_distribution_quota_total_s5')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div> -->

                                    <div class="form-group @error('english_program') is-invalid @enderror">
                                        <label>{{ trans('admin/pages/universities.english_program') }}</label>
                                        <div class="form-check">
                                            <input type="checkbox" name="english_program" class="form-check-input" value="1" {{ empty($universities) && $university->english_program ? 'checked' : '' }} />
                                            <label class="form-check-label">{{ trans('admin/main.yes') }}</label>
                                        </div>
                                        @error('english_program')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('5_graduate_system_can_apply') is-invalid @enderror">
                                        <label>{{ trans('admin/pages/universities.5_graduate_system_can_apply') }}</label>
                                        <div class="form-check">
                                            <input type="checkbox" name="5_graduate_system_can_apply" class="form-check-input" value="1" {{ empty($universities) && $university["5_graduate_system_can_apply"] ? 'checked' : '' }} />
                                            <label class="form-check-label">{{ trans('admin/main.yes') }}</label>
                                        </div>
                                        @error('5_graduate_system_can_apply')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">{{ empty($universities) ? trans('admin/main.update') : trans('admin/main.create') }}</button>
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