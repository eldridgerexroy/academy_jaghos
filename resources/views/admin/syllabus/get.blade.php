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

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="float-right">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#addSyllabusModal">{{ trans('admin/main.add_new') }}</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="text-left">{{ trans('admin/pages/syllabus.title') }}</th>
                                            <th>{{ trans('admin/pages/syllabus.description') }}</th>
                                            <th>{{ trans('admin/pages/syllabus.year') }}</th>
                                            <th>{{ trans('admin/pages/syllabus.major') }}</th>
                                            <th>{{ trans('admin/pages/syllabus.university') }}</th>
                                            <th>{{ trans('admin/pages/syllabus.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($syllabi->groupBy('university_id') as $universityId => $syllabiByUniversity)
                                            @php
                                                $university = \App\Models\University::findOrFail($universityId);
                                            @endphp
                                            <tr>
                                                <td colspan="7">
                                                    <h4>{{ $university->name }}</h4>
                                                </td>
                                            </tr>
                                            @foreach($syllabiByUniversity->groupBy('major_id') as $majorId => $syllabiByMajor)
                                                @php
                                                    $major = \App\Models\Major::findOrFail($majorId);
                                                @endphp
                                                @foreach($syllabiByMajor as $syllabus)
                                                    <tr>
                                                        <td>{{ $syllabus->id }}</td>
                                                        <td class="text-left">{{ $syllabus->title }}</td>
                                                        <td>{{ $syllabus->description }}</td>
                                                        <td>{{ $syllabus->year }}</td>
                                                        <td>{{ $major->name }}</td>
                                                        <td>{{ $university->name }}</td>
                                                        <td>
                                                            <a href="{{ getAdminPanelUrl() }}/syllabus/{{ $syllabus->id }}/edit" class="btn-transparent text-primary">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            @include('admin.includes.delete_button', ['url' => getAdminPanelUrl() . '/syllabus/' . $syllabus->id . '/delete'])
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
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

    <!-- Add Syllabus Modal -->
    <div class="modal fade" id="addSyllabusModal" tabindex="-1" role="dialog" aria-labelledby="addSyllabusModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ getAdminPanelUrl() . '/syllabus/store' }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSyllabusModalLabel">{{ trans('admin/main.add_new_syllabus') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="syllabusTitle">{{ trans('admin/pages/syllabus.title') }}</label>
                            <input type="text" class="form-control" id="syllabusTitle" name="title" placeholder="{{ trans('admin/pages/syllabus.enter_title') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="syllabusDescription">{{ trans('admin/pages/syllabus.description') }}</label>
                            <textarea class="form-control" id="syllabusDescription" name="description" rows="4" placeholder="{{ trans('admin/pages/syllabus.enter_description') }}"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="syllabusYear">{{ trans('admin/pages/syllabus.year') }}</label>
                            <input type="number" class="form-control" id="syllabusYear" name="year" placeholder="{{ trans('admin/pages/syllabus.enter_year') }}" min="1900" max="2100" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('admin/main.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('admin/main.save_changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
