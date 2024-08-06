<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\WebinarSchedule;

class WebinarScheduleController extends Controller
{
    public function index()
    {
        $schedules = WebinarSchedule::with('webinar')->get();
        $pageTitle = 'All Webinar Schedules';

        $events = [];

        foreach ($schedules as $schedule) {
            foreach (json_decode($schedule->days_of_week) as $day) {
                $events[] = [
                    'title' => $schedule->webinar->title ?? 'No Webinar',
                    'startTime' => $schedule->start_time,
                    'endTime' => $schedule->end_time,
                    'daysOfWeek' => [getDayOfWeekIndex($day)],
                    'description' => 'Timezone: ' . $schedule->timezone,
                    'backgroundColor' => '#007bff',
                    'borderColor' => '#007bff'
                ];
            }
        }

        return view('web.default.schedule.index', [
            'events' => $events,
            'pageTitle' => $pageTitle
        ]);
    }
}
