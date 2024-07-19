@extends('admin.layouts.app')

@push('libraries_top')
<link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ $pageTitle }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
            <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl() }}/universities">{{ trans('admin/main.universities') }}</a></div>
            <div class="breadcrumb-item">{{ $university->name }}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ $university->name }}</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>{{ trans('admin/pages/universities.title') }}</th>
                                <td>{{ $university->name }}</td>
                                <th>{{ trans('admin/pages/universities.city') }}</th>
                                <td>{{ $university->city }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('admin/pages/universities.country') }}</th>
                                <td>{{ $university->country }}</td>
                                <th>{{ trans('admin/pages/universities.picture') }}</th>
                                <td>
                                    @if($university->picture)
                                    <img src="{{ '/store/' . $university->picture }}" alt="University Picture" class="university-picture">
                                    @else
                                    <p>No Picture</p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>{{ trans('admin/pages/universities.created_at') }}</th>
                                <td colspan="3">{{ $university->created_at }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ $university->name }} - {{ trans('admin/pages/universities.majors') }}</h4>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMajorModal">
                            {{ trans('admin/pages/universities.add_major') }}
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="font-weight: bold;">{{ trans('admin/pages/universities.department_name') }}</th>
                                    <th>{{ trans('admin/pages/universities.major_name') }}</th>
                                    <th>{{ trans('admin/pages/universities.major_description') }}</th>
                                    <th>{{ trans('admin/pages/universities.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($university->majors->isNotEmpty())
                                    @foreach($universityMajors as $university_major)
                                    <tr>
                                        <td>{{ $university_major->department->name }}</td>
                                        <td>{{ $university_major->major->name }}</td>
                                        <td>{{ $university_major->major->description }}</td>
                                        <td>
                                            <a href="{{ getAdminPanelUrl() }}/syllabus/{{ $university_major->id }}" class="btn-transparent text-primary">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <!-- @include('admin.includes.delete_button', ['url' => getAdminPanelUrl() . '/universities/' . $university->id . '/delete']) -->
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan=4>{{ trans('admin/pages/universities.no_majors') }}</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ getAdminPanelUrl() }}/universities" class="btn btn-secondary">{{ trans('admin/main.back') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add Major Modal -->
<div class="modal fade" id="addMajorModal" tabindex="-1" role="dialog" aria-labelledby="addMajorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMajorModalLabel">{{ trans('admin/pages/universities.add_major') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addMajorForm" action="{{ route('universities.majors.store', $university->id) }}" method="POST">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="universityName">{{ trans('admin/pages/universities.university_name') }}</label>
                        <input type="text" class="form-control" id="universityName" name="university_name" value="{{ $university->name }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="departmentSelect">{{ trans('admin/pages/universities.department_name') }}</label>
                        <select class="form-control" name="department_id">
                            <option></option>
                            @foreach($allDepartments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ trans('admin/pages/universities.major_name') }}</th>
                                <th>{{ trans('admin/pages/universities.major_description') }}</th>
                                <th>{{ trans('admin/pages/universities.actions') }}</th>
                            </tr>
                        </thead>

                        <tbody id="majorTableBody">
                            @foreach($allMajors as $major)
                            <tr data-id="{{ $major->id }}">
                                <td>{{ $major->name }}</td>
                                <td>{{ $major->description }}</td>
                                <td><button type="button" class="btn btn-success add-major-btn" data-id="{{$major->id}}">{{ trans('admin/pages/universities.add') }}</button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </form>
        </div> 
    </div>
</div>
@endsection

@push('scripts_bottom')
<script>
    var universityId = {{$university -> id}};
</script>
<script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="/assets/default/js/admin/main.min.js"></script>
@endpush

<style>
    .university-picture {
        border-radius: 50%;
        max-width: 100px;
        max-height: 100px;
    }

    .modal-dialog-centered {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: calc(100% - 1rem);
    }
    .swal2-container {
        z-index: 20000 !important;
    }
</style>