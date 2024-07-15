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
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="float-right">
                                <a href="{{ getAdminPanelUrl() }}/syllabus/create" class="btn btn-primary">{{ trans('admin/main.add_new') }}</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="syllabusTable" class="table table-striped font-14">
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
                                        @foreach($syllabi as $syllabus)
                                            <tr>
                                                <td>{{ $syllabus->id }}</td>
                                                <td class="text-left">{{ $syllabus->title }}</td>
                                                <td>{{ $syllabus->description }}</td>
                                                <td>{{ $syllabus->year }}</td>
                                                <td>{{ $syllabus->major->name }}</td>
                                                <td>{{ $syllabus->university->name }}</td>
                                                <td>
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

@push('scripts_bottom')
    <script>
        $(document).ready(function() {
            $('#syllabusTable').DataTable({
                "paging": true,             // Enable pagination
                "ordering": true,           // Enable sorting
                "searching": true,          // Enable search box
                "info": true,               // Show table information
                "responsive": true          // Enable responsive mode
            });
        });
    </script>
@endpush
