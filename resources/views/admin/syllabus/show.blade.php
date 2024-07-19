@extends('admin.layouts.app')

@push('libraries_top')
<link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('content')
<section class="section syllabus-section">
    <div class="section-header">
        <h1 class="display-4 text-center">{{ $pageTitle }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
            <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl() }}/syllabus/{{$university_major_id}}">{{ trans('admin/main.syllabus') }}</a></div>
            <div class="breadcrumb-item">{{ trans('admin/main.syllabus_detail') }}</a></div>
        </div>
    </div>

    <div class="mb-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 font-weight-bold">{{ trans('admin/main.university') }}:</div>
                    <div class="col-md-6"><b>{{ $university->name }}</b></div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-2 font-weight-bold">{{ trans('admin/main.department') }}:</div>
                    <div class="col-md-6"><b>{{ $department->name }}</b></div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-2 font-weight-bold">{{ trans('admin/main.major') }}:</div>
                    <div class="col-md-6"><b>{{ $major->name }}</b></div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-2 font-weight-bold">{{ trans('admin/pages/syllabus.title') }}:</div>
                    <div class="col-md-6"><b>{{ $syllabus->title }}</b></div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-12">
        <div class="card">
            <div class="card-body">
                <div class="col-12">
                    <h4 class="font-weight-bold my-2">{{ trans('admin/pages/syllabus.topics') }}</h4>
                    <form id="add-topic-form" method="POST" action="{{ getAdminPanelUrl() . '/syllabus/topic/store'}}">
                        @csrf
                        <input type="hidden" name="syllabus_id" value="{{$syllabus->id}}">
                        <div class="form-group">
                            <label for="week">{{ trans('admin/pages/syllabus.topic_title') }}</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="title">{{ trans('admin/pages/syllabus.topic_description') }}</label>
                            <input type="text" name="description" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ trans('admin/pages/syllabus.add_topic') }}</button>
                    </form>
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ trans('admin/pages/syllabus.topic_title') }}</th>
                                    <th>{{ trans('admin/pages/syllabus.topic_description') }}</th>
                                    <th>{{ trans('admin/pages/syllabus.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody id="syllabus-topics-table-body">
                                @foreach($syllabusTopics as $topic)
                                <tr>
                                    <td>{{ $topic->title }}</td>
                                    <td>{{ $topic->description }}</td>
                                    <td>
                                        <!-- <a href="javascript:void(0)" class="edit-topic" data-id="{{ $topic->id }}"><i class="fa fa-edit"></i></a> -->
                                        <a href="javascript:void(0)" class="delete-topic" data-id="{{ $topic->id }}"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-body syllabus-detail text-center">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card card-center shadow-lg">
                    <div class="card-body">
                        <div class="row mb-4 justify-content-center">
                            <div class="col-12">
                                <h2 class="font-weight-bold">{{ trans('admin/pages/syllabus.title') }}</h2>
                                <p class="lead">{{ $syllabus->title }}</p>
                            </div>
                        </div>
                        <div class="row mb-4 justify-content-center">
                            <div class="col-12">
                                <h4 class="font-weight-bold">{{ trans('admin/pages/syllabus.year') }}</h4>
                                <p>{{ $syllabus->year }}</p>
                            </div>
                        </div>
                        <div class="row mb-4 justify-content-center">
                            <div class="col-12">
                                <h4 class="font-weight-bold">{{ trans('admin/pages/syllabus.course_overview') }}</h4>
                                <p>{!! $syllabus->course_overview !!}</p>
                            </div>
                        </div>
                        <div class="row mb-4 justify-content-center">
                            <div class="col-12">
                                <h4 class="font-weight-bold">{{ trans('admin/pages/syllabus.course_objectives') }}</h4>
                                <p>{!! $syllabus->course_objectives !!}</p>
                            </div>
                        </div>
                        <div class="row mb-4 justify-content-center">
                            <div class="col-12">
                                <h4 class="font-weight-bold">{{ trans('admin/pages/syllabus.grading_policy') }}</h4>
                                <p>{!! $syllabus->grading_policy !!}</p>
                            </div>
                        </div>
                        <div class="row mb-4 justify-content-center">
                            <div class="col-12">
                                <h4 class="font-weight-bold">{{ trans('admin/pages/syllabus.assignments') }}</h4>
                                <p>{!! $syllabus->assignments !!}</p>
                            </div>
                        </div>
                        <div class="row mb-4 justify-content-center">
                            <div class="col-12">
                                <h4 class="font-weight-bold">{{ trans('admin/pages/syllabus.required_readings') }}</h4>
                                <p>{!! $syllabus->required_readings !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="/assets/default/js/admin/main.min.js"></script>
@endpush

<style>
    .syllabus-section {
        color: black;
    }

    .card-center {
        text-align: center;
    }
</style>