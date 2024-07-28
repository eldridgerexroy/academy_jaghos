@extends('admin.layouts.app')

@push('libraries_top')

@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ trans('admin/main.universities') }}</div>
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
                                <a href="{{ getAdminPanelUrl() }}/universities/create" class="btn btn-primary">{{ trans('admin/main.add_new') }}</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="text-left">{{ trans('admin/pages/universities.title') }}</th>
                                            <th>{{ trans('admin/pages/universities.city') }}</th>
                                            <th>{{ trans('admin/pages/universities.country') }}</th>
                                            <th>{{ trans('admin/pages/universities.picture') }}</th>
                                            <th>{{ trans('admin/pages/universities.created_at') }}</th>
                                            <th>{{ trans('admin/pages/universities.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($universities as $university)
                                            <tr>
                                                <td>{{ $university->id }}</td>
                                                <td class="text-left">{{ $university->name }}</td>
                                                <td>{{ $university->city->name }}</td>
                                                <td>{{ $university->country->name }}</td>
                                                <td>
                                                    @if($university->picture)
                                                        <img src="{{ asset('store/1/academy/' . $university['picture']) }}" alt="{{$university->name}}" class="img-cover">
                                                    @else
                                                        No Picture
                                                    @endif
                                                </td>
                                                <td>{{ $university->created_at }}</td>
                                                <td>
                                                    <a href="{{ getAdminPanelUrl() }}/universities/{{ $university->id }}" class="btn-transparent text-primary">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="{{ getAdminPanelUrl() }}/universities/{{ $university->id }}/edit" class="btn-transparent text-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    @include('admin.includes.delete_button', ['url' => getAdminPanelUrl() . '/universities/' . $university->id . '/delete'])
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            {{ $universities->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')

@endpush
