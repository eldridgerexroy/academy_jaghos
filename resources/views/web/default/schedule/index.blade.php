@extends('web.default.layouts.app')

@push('styles_top')
<!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid/main.css" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-12">
                <section class="section">
                    <div class="section-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="section-header text-center">
                                    <h1>{{ $pageTitle }}</h1>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div id="calendar2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar2');
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
