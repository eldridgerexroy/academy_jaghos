@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')

@endpush

@section('content')
    <section>
        <div class="section-header mb-3">
            <h1>{{ !empty($request_recording) ? trans('admin/main.edit') : trans('admin/main.new') }} {{ trans('admin/main.request_recording') }}</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-3">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mb-3">
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
                            <form action="{{ url('panel/webinars/request_recording/' . (!empty($request_recording) ? $request_recording->id.'/update' : 'store')) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-group @error('requester') is-invalid @enderror">
                                            <label>{{ trans('admin/pages/webinars.webinars_recording_request_requester') }}</label>
                                            <input readonly type="text" name="requester" class="form-control" value="{{ Auth::user()->full_name }}" placeholder=""/>
                                            @error('requester')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group @error('reason') is-invalid @enderror">
                                            <label>{{ trans('admin/pages/webinars.webinars_recording_request_reason') }}</label>
                                            <input type="text" name="reason" class="form-control" value="{{ !empty($request_recording) ? $request_recording->reason : old('reason') }}" placeholder=""/>
                                            @error('reason')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group @error('email') is-invalid @enderror">
                                            <label>{{ trans('admin/pages/webinars.webinars_recording_request_email') }} </label>
                                            <input type="email" name="email" class="form-control" value="{{ !empty($request_recording) ? $request_recording->email : old('email') }}" placeholder=""/>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group @error('webinar_id') is-invalid @enderror">
                                            <label>{{ trans('admin/pages/webinars.webinars_recording_request_course') }}</label>
                                            <select name="webinar_id" class="form-control">
                                                <option value="">Select Course</option>
                                                @foreach($webinar_recording as $webinar)
                                                    @if(in_array($webinar->id, $purchased_courses))
                                                        <option value="{{ $webinar->id }}" {{ !empty($request_recording) && $request_recording->webinar_id == $webinar->id ? 'selected' : '' }}>
                                                            {{ $webinar->slug }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('webinar_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group @error('date') is-invalid @enderror">
                                            <label>{{ trans('admin/pages/webinars.webinars_recording_request_date') }}</label>
                                            <input type="date" name="date" class="form-control" value="{{ !empty($request_recording) ? $request_recording->date : old('date') }}" placeholder=""/>
                                            @error('date')
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

    <div class="my-30">
        {{-- {{ $sales->appends(request()->input())->links('vendor.pagination.panel') }} --}}
    </div>

    @include('web.default.panel.webinar.join_webinar_modal')
@endsection

@push('scripts_bottom')
    <script>
        var undefinedActiveSessionLang = '{{ trans('webinars.undefined_active_session') }}';
    </script>

    <script src="/assets/default/js/panel/join_webinar.min.js"></script>
@endpush
