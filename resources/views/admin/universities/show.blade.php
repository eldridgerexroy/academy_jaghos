@extends('admin.layouts.app')

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
                            <div class="form-group">
                                <label>{{ trans('admin/pages/universities.title') }}:</label>
                                <p>{{ $university->name }}</p>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('admin/pages/universities.city') }}:</label>
                                <p>{{ $university->city }}</p>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('admin/pages/universities.country') }}:</label>
                                <p>{{ $university->country }}</p>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('admin/pages/universities.picture') }}:</label>
                                <br>
                                @if($university->picture)
                                    <img src="{{ '/store/' . $university->picture }}" alt="University Picture" style="max-width: 200px;">
                                @else
                                    <p>No Picture</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>{{ trans('admin/pages/universities.created_at') }}:</label>
                                <p>{{ $university->created_at }}</p>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ getAdminPanelUrl() }}/universities/{{ $university->id }}/edit" class="btn btn-primary">{{ trans('admin/main.edit') }}</a>
                            <a href="{{ getAdminPanelUrl() }}/universities" class="btn btn-secondary">{{ trans('admin/main.back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
