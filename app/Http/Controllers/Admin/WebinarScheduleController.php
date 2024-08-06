<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebinarSchedule;
use App\Models\Webinar;

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

        return view('admin.webinars.schedules.index', [
            'events' => $events,
            'pageTitle' => $pageTitle
        ]);
    }

    public function webinarSchedule($id)
    {
        $webinars = Webinar::all();
        $selected_webinar = Webinar::find($id);
        $webinar_schedules = WebinarSchedule::with('webinar')->where('webinar_id',$id)->get();

        if(!$selected_webinar){
            $webinar_schedules = WebinarSchedule::with('webinar')->get();
        }

        $data = [
            'pageTitle' => trans('admin/pages/webinars.webinar_schedule'),
            'webinars' => $webinars,
            'selected_webinar' => $selected_webinar,
            'webinar_schedules' => $webinar_schedules
        ];

        return view('admin.webinars.schedules.schedule', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'webinar_id' => 'required|exists:webinars,id',
            'days_of_week' => 'required|array',
            'days_of_week.*' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
            'timezone' => 'required|string',
        ]);

        WebinarSchedule::create([
            'webinar_id' => $validated['webinar_id'],
            'days_of_week' => json_encode($validated['days_of_week']),
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'timezone' => $validated['timezone'],
        ]);

        return back()->with('success', "Schedule Added Successfully");
    }

    public function destroy($id){
        $webinar = WebinarSchedule::findOrFail($id);

        $webinar->delete();
        
        return back()->with('success', "Schedule Deleted Successfully");
    }
}
