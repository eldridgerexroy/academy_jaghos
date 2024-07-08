<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebinarRecordingRequest;
use App\Models\Webinar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebinarRecordingRequestController extends Controller
{
    public function index()
    {
        $webinar_recording = WebinarRecordingRequest::orderBy('created_at', 'asc')->paginate(10);

        $data = [
            'pageTitle' => trans('admin/pages/webinars.webinars_recording_request_title'),
            'webinar_requests' => $webinar_recording,
        ];

        return view('admin.webinars.recording_request.lists', $data);
    }

    public function show($id)
    {
        $webinar_recording = WebinarRecordingRequest::findOrFail($id);

        $data = [
            'pageTitle' => trans('admin/webinars_recording_detail'),
            'webinar_recording' => $webinar_recording,
        ];

        return view('admin.webinars.recording_request.show', $data);
    }

    public function create()
    {
        $webinar_recording = Webinar::All();
        $data = [
            'pageTitle' => trans('admin/webinars_recording_create'),
            'webinar_recording' => $webinar_recording
        ];

        return view('admin.webinars.recording_request.create', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'requester' => 'required|min:3|max:64',
            'reason' => 'required|min:3|max:255',
            'email' => 'required|email|max:255',
            'webinar_id' => 'required',
            'date' => 'required|date',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        WebinarRecordingRequest::create($data);

        return back()->with('success', 'Webinar recording request created successfully.');
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
        $university = WebinarRecordingRequest::findOrFail($id);
        $university->delete();

        return back()->with('success', 'University deleted successfully.');
    }
}
