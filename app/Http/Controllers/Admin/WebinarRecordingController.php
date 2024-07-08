<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebinarRecording;
use App\Models\Webinar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebinarRecordingController extends Controller
{
    public function index()
    {
        $webinar_recording = WebinarRecording::join("webinars", "webinar_recording.webinar_id", "=", "webinars.id")
                            ->select("webinar_recording.*", "webinars.slug as webinar_name")
                            ->orderBy('webinar_recording.created_at', 'asc')
                            ->paginate(10);
        $data = [
            'pageTitle' => trans('admin/pages/webinars.webinars_recording_title'),
            'webinars_recordings' => $webinar_recording,
        ];

        return view('admin.webinars.recordings.lists', $data);
    }

    public function show($id)
    {
        $webinar_recording = WebinarRecording::findOrFail($id);

        $data = [
            'pageTitle' => trans('admin/webinars_recording_detail'),
            'webinar_recording' => $webinar_recording,
        ];

        return view('admin.webinars.recordings.show', $data);
    }

    public function create()
    {
        $webinars = Webinar::All();
        $data = [
            'pageTitle' => trans('admin/webinars_recording_create'),
            'webinars' => $webinars
        ];

        return view('admin.webinars.recordings.create', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'link' => 'required',
            'webinar_id' => 'required',
            'date' => 'required|date',
        ]);

        $data = $request->all();

        WebinarRecording::create($data);

        return back()->with('success', 'Webinar recording created successfully.');
    }

    // public function edit($id)
    // {
    //     $university = University::findOrFail($id);

    //     $data = [
    //         'pageTitle' => trans('admin/main.edit'),
    //         'university' => $university,
    //     ];

    //     return view('admin.universities.create', $data);
    // }

    // public function update(Request $request, $id)
    // {
    //     // $this->authorize('admin_university_edit');

    //     $university = University::findOrFail($id);

    //     $this->validate($request, [
    //         'name' => 'required|min:3|max:64|unique:universities,name,' . $id,
    //         'city' => 'required|min:2|max:64',
    //         'country' => 'required|min:2|max:64',
    //         'picture' => 'nullable|image|max:2048', // 2MB max size
    //     ]);

    //     $data = $request->all();

    //     if ($request->hasFile('picture')) {
    //         // Delete the old picture if it exists
    //         if ($university->picture) {
    //             Storage::disk('public')->delete($university->picture);
    //         }
    //         $data['picture'] = $request->file('picture')->store('pictures', 'public');
    //     }

    //     $university->update($data);

    //     Cache::forget('sections');

    //     return back()->with('success', 'University updated successfully.');
    // }

    public function destroy($id)
    {
        $university = WebinarRecording::findOrFail($id);
        $university->delete();

        return back()->with('success', 'University deleted successfully.');
    }
}
