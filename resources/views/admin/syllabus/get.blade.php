@extends('admin.layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ $pageTitle }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
            <div class="breadcrumb-item">{{ trans('admin/main.syllabi') }}</div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

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
            </div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-right">
                            <a href="{{ getAdminPanelUrl() }}/syllabus/create/{{$university_major_id}}">
                                <button class="btn btn-primary">{{ trans('admin/main.add_new') }}</button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped font-14">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-left">{{ trans('admin/pages/syllabus.title') }}</th>
                                        <th>{{ trans('admin/pages/syllabus.course_overview') }}</th>
                                        <th>{{ trans('admin/pages/syllabus.year') }}</th>
                                        <th>{{ trans('admin/pages/syllabus.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($syllabi as $syllabus)
                                    <tr>
                                        <td>{{ $syllabus->id }}</td>
                                        <td class="text-left">{{ $syllabus->title }}</td>
                                        <td>{!! Str::limit($syllabus->course_overview, 30) !!}</td>
                                        <td>{{ $syllabus->year }}</td>
                                        <td>
                                            <a href="{{ getAdminPanelUrl() }}/syllabus/detail/{{ $syllabus->id }}" class="btn-transparent text-primary">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ getAdminPanelUrl() }}/syllabus/{{ $syllabus->id }}/edit" class="btn-transparent text-primary">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @include('admin.includes.delete_button', ['url' => getAdminPanelUrl() . '/syllabus/' . $syllabus->id . '/delete'])
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
    </div>
</section>
@endsection