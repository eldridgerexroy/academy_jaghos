<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Syllabus;
use App\Models\University;
use App\Models\Major;
use App\Models\SyllabusTopic;
use App\Models\UniversityMajor;


class SyllabusController extends Controller
{
    /**
     * Display a listing of the syllabi.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $syllabi = Syllabus::all();

        $data = [
            'pageTitle' => trans('admin/pages/syllabus.page_lists_title'),
            'syllabi' => $syllabi,
        ];

        return view('admin.syllabus.lists', $data);
    }

    public function show($id)
    {
        $syllabus = Syllabus::find($id);
        $syllabus_topic = SyllabusTopic::where("syllabus_id", $id)->get();
        
        $university_major = UniversityMajor::find($syllabus->university_major_id);

        $university = $university_major->university;
        $major = $university_major->major;
        $department = $university_major->department;

        $data = [
            'pageTitle' => trans('admin/pages/syllabus.page_show_title'),
            'syllabus' => $syllabus,
            'syllabusTopics' => $syllabus_topic,
            'major' => $major,
            'university' => $university,
            'department' => $department,
            'university_major_id' => $syllabus->university_major_id,
        ];

        return view('admin.syllabus.show', $data);
    }

    /**
     * Show the form for creating a new syllabus.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $university_major = UniversityMajor::find($id);

        $university = $university_major->university;
        $major = $university_major->major;
        $department = $university_major->department;

        $data = [
            'pageTitle' => trans('admin/pages/syllabus.page_lists_title'),
            'major' => $major,
            'university' => $university,
            'department' => $department,
            'university_major_id' => $id
        ];

        return view('admin.syllabus.create', $data);
    }

    /**
     * Store a newly created syllabus in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'year' => 'required|numeric|max:2100',
            'course_overview' => 'nullable',
            'course_objectives' => 'nullable',
            'grading_policy' => 'nullable',
            'assignments' => 'nullable',
            'required_readings' => 'nullable',
        ]);

        Syllabus::create([
            'title' => $request->title,
            'year' => $request->year,
            'course_overview' => $request->course_overview,
            'course_objectives' => $request->course_objectives,
            'grading_policy' => $request->grading_policy,
            'assignments' => $request->assignments,
            'required_readings' => $request->required_readings,
            'university_major_id' => $request->university_major_id,
        ]);

        $universityMajorId = $request->university_major_id;
    
        return redirect()->route('admin.syllabus.index', ['university_major_id' => $universityMajorId])->with('success', 'Syllabus created successfully.');
    }

    /**
     * Show the form for editing the specified syllabus.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $syllabus = Syllabus::findOrFail($id);
        $universities = University::all();
        $majors =  Major::all();

        $data = [
            'pageTitle' => trans('admin/pages/syllabus.page_lists_title'),
            'majors' => $majors,
            'universities' => $universities,
            'syllabus' => $syllabus,
        ];

        return view('admin.syllabus.create', $data);
    }

    /**
     * Update the specified syllabus in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'major_id' => 'required',
            'university_id' => 'required',
            'title' => 'required',
            'description' => 'nullable',
            'year' => 'required|numeric|max:2100',
        ]);

        $syllabus = Syllabus::findOrFail($id);
        $syllabus->update($request->all());

        return back()->with('success', 'Syllabus updated successfully.');
    }

    /**
     * Remove the specified syllabus from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $syllabus = Syllabus::findOrFail($id);
        $syllabus->delete();

        return redirect()->route('admin.syllabus.index')->with('success', 'Syllabus deleted successfully.');
    }

    /**
     * Display the specified syllabus.
     *
     * @param  int  $university_id
     * @param  int  $major_id
     * @return \Illuminate\Http\Response
     */
    public function getSyllabus($university_major_id)
    {
        $university_major = UniversityMajor::find($university_major_id);

        $university = $university_major->university;
        $major = $university_major->major;
        $department = $university_major->department;

        $syllabi = Syllabus::where("university_major_id",$university_major_id)->get();

        $data = [
            'pageTitle' => trans('admin/pages/syllabus.page_lists_title'),
            'major' => $major,
            'university' => $university,
            'department' => $department,
            'syllabi' => $syllabi,
            'university_major_id' => $university_major_id
        ];

        return view('admin.syllabus.get', $data);
    }
}