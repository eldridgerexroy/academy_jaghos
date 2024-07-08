@extends('admin.layouts.app')

@push('libraries_top')
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ !empty($university) ? trans('admin/main.edit') : trans('admin/main.new') }} {{ trans('admin/main.university') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}/universities">{{ trans('admin/main.universities') }}</a></div>
                <div class="breadcrumb-item">{{ !empty($university) ? trans('admin/main.edit') : trans('admin/main.new') }}</div>
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
                            <form action="{{ getAdminPanelUrl() }}/universities/{{ !empty($university) ? $university->id.'/update' : 'store' }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group @error('name') is-invalid @enderror">
                                            <label>{{ trans('admin/main.name') }}</label>
                                            <input type="text" name="name" class="form-control" value="{{ !empty($university) ? $university->name : old('name') }}" placeholder=""/>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group @error('city') is-invalid @enderror">
                                            <label>{{ trans('admin/pages/universities.city') }}</label>
                                            <input type="text" name="city" class="form-control" value="{{ !empty($university) ? $university->city : old('city') }}" placeholder=""/>
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group @error('country') is-invalid @enderror">
                                            <label>{{ trans('admin/pages/universities.country') }}</label>
                                            <input type="text" name="country" class="form-control" value="{{ !empty($university) ? $university->country : old('country') }}" placeholder=""/>
                                            @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group @error('picture') is-invalid @enderror">
                                            <label>{{ trans('admin/pages/universities.picture') }}</label>
                                            <input type="file" name="picture" class="form-control"/>
                                            @if(!empty($university) && $university->picture)
                                                <div class="mt-2">
                                                    <img src="{{ '/store/' . $university->picture }}" alt="University Picture" style="max-width: 150px;">
                                                </div>
                                            @endif
                                            @error('picture')
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
@endpush
