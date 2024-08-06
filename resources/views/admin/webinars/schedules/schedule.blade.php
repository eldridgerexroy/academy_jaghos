@extends('admin.layouts.app')

@push('libraries_top')
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ $pageTitle }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
            <div class="breadcrumb-item"><a href="{{ getAdminPanelUrl() . '/webinars' }}">{{ trans('admin/main.webinar') }}</a></div>
            <div class="breadcrumb-item">{{ trans('admin/main.webinar_schedule') }}</div>
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
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.webinar_schedule.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="webinar_id" value="{{$selected_webinar->id ?? 0}}">
                            <div class="form-group">
                                <label for="webinar_id">{{ trans('admin/pages/webinars.select_webinar') }}</label>
                                <select name="webinar_id" id="webinar_id" class="form-control select2" {{ isset($selected_webinar) ? 'disabled' : '' }}>
                                    @foreach($webinars as $webinar)
                                        <option value="{{ $webinar->id }}" {{ ($webinar->id == ($selected_webinar->id ?? 0)) ? 'selected' : '' }}>
                                            {{ $webinar->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>{{ trans('admin/pages/webinars.days_of_week') }}</label>
                                <div class="row">
                                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                    <div class="col">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="days_of_week[]" value="{{ $day }}" class="custom-control-input" id="day_{{ $day }}">
                                            <label class="custom-control-label" for="day_{{ $day }}">{{ $day }}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="start_time">{{ trans('admin/pages/webinars.start_time') }}</label>
                                <input type="time" name="start_time" id="start_time" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="end_time">{{ trans('admin/pages/webinars.end_time') }}</label>
                                <input type="time" name="end_time" id="end_time" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="timezone">{{ trans('admin/pages/webinars.timezone') }}</label>
                                <input type="text" name="timezone" id="timezone" class="form-control" value="WIB" readonly>
                            </div>

                            <button type="submit" class="btn btn-primary">{{ trans('admin/main.save') }}</button>
                        </form>

                        <div class="table-responsive mt-4">
                            <table class="table table-striped font-14">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ trans('admin/pages/webinars.webinar') }}</th>
                                        <th><b>{{ trans('admin/pages/webinars.days_of_week') }}</b></th>
                                        <th>{{ trans('admin/pages/webinars.start_time') }}</th>
                                        <th>{{ trans('admin/pages/webinars.end_time') }}</th>
                                        <th>{{ trans('admin/pages/webinars.timezone') }}</th>
                                        <th>{{ trans('admin/main.actions') }}</th>
                                    </tr>key
                                </thead>
                                <tbody>
                                    @foreach($webinar_schedules as $key => $schedule)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $schedule->webinar->title }}</td>
                                        <td>{{ implode(', ', json_decode($schedule->days_of_week)) }}</td>
                                        <td>{{ $schedule->start_time }}</td>
                                        <td>{{ $schedule->end_time }}</td>
                                        <td>{{ $schedule->timezone }}</td>
                                        <td>
                                            @include('admin.includes.delete_button', ['url' => getAdminPanelUrl() . '/webinars/schedule/' . $schedule->id . '/delete'])
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        {{-- $webinar_schedules->appends(request()->input())->links() --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts_bottom')
@endpush
