@extends('admin.layouts.app')

@push('libraries_top')
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid/main.css" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ trans('admin/pages/webinars.webinars_schedules') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="float-right">
                                <a href="{{ getAdminPanelUrl() }}/webinars/schedules/create" class="btn btn-primary">{{ trans('admin/main.add_new') }}</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>

                        <div class="card-footer text-center">
                            {{-- Pagination or other footer content --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                slotMinTime: '09:00:00',
                slotMaxTime: '23:00:00',
                height: 'auto',
                contentHeight: 'auto',
                headerToolbar: false,
                columnHeaderFormat: { weekday: 'long' }, // Display only the weekday names
                titleFormat: { day: 'numeric' }, // Customize to show only days if needed
                views: {
                    timeGridWeek: {
                        dayHeaderFormat: { weekday: 'long' } // Ensure only weekdays are shown
                    }
                },
                events: @json($events),
                eventClick: function(info) {
                    Swal.fire({
                        title: 'Schedule: ' + info.event.title,
                        html: '<div style="text-align: center;">Time: ' + 
                            info.event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) + 
                            ' - ' + info.event.end.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) + 
                            '</div>',
                    });
                }
            });
            calendar.render();
        });
    </script>
@endpush