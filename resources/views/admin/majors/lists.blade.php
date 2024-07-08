@extends('admin.layouts.app')

@push('libraries_top')

@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ trans('admin/main.majors') }}</div>
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
                                <a href="{{ getAdminPanelUrl() }}/majors/create" class="btn btn-primary">{{ trans('admin/main.add_new') }}</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="text-left">{{ trans('admin/pages/majors.title') }}</th>
                                            <th>{{ trans('admin/pages/majors.description') }}</th>
                                            <th>{{ trans('admin/pages/majors.created_at') }}</th>
                                            <th>{{ trans('admin/pages/majors.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($majors as $university)
                                            <tr>
                                                <td>{{ $university->id }}</td>
                                                <td class="text-left">{{ $university->name }}</td>
                                                <td>{{ $university->description }}</td>
                                                <td>{{ $university->created_at }}</td>
                                                <td>
                                                    <a href="{{ getAdminPanelUrl() }}/majors/{{ $university->id }}/edit" class="btn-transparent text-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    @include('admin.includes.delete_button', ['url' => getAdminPanelUrl() . '/majors/' . $university->id . '/delete'])
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $majors->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')

@endpush