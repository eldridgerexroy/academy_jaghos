<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Syllabus;
use App\Models\University;
use App\Models\Major;


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

    /**
     * Show the form for creating a new syllabus.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $universities = University::all();
        $majors =  Major::all();

        $data = [
            'pageTitle' => trans('admin/pages/syllabus.page_lists_title'),
            'majors' => $majors,
            'universities' => $universities,
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
            'major_id' => 'required',
            'university_id' => 'required',
            'title' => 'required',
            'description' => 'nullable',
            'year' => 'required|numeric|max:2100',
        ]);

        Syllabus::create($request->all());

        return back()->with('success', 'Syllabus created successfully.');
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
    public function getSyllabus($university_id, $major_id)
    {
        $syllabus = Syllabus::where('university_id', $university_id)
            ->where('major_id', $major_id)
            ->get();

        $university = University::findOrFail($university_id);
        $major = Major::findOrFail($major_id);

        $data = [
            'pageTitle' => trans('admin/pages/syllabus.page_lists_title'),
            'major' => $major,
            'university' => $university,
            'syllabi' => $syllabus,
        ];

        return view('admin.syllabus.get', $data);
    }
}
