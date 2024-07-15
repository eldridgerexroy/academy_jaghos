<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\University;
use App\Models\Major;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class UniversityController extends Controller
{
    public function index()
    {
        // $this->authorize('admin_university_list');

        $universities = University::orderBy('created_at', 'asc')->paginate(10);

        $data = [
            'pageTitle' => trans('admin/pages/universities.page_lists_title'),
            'universities' => $universities,
        ];

        return view('admin.universities.lists', $data);
    }

    public function show($id)
    {
        $university = University::with(['majors.departments'])->findOrFail($id);
        $allMajors = Major::all();
        $allDepartments = Department::all();
        $universityMajors = $university->majors;

        $data = [
            'pageTitle' => trans('admin/main.university_detail'),
            'university' => $university,
            'allMajors' => $allMajors,
            'allDepartments' => $allDepartments,
            'universityMajors' => $universityMajors,
        ];

        return view('admin.universities.show', $data);
    }

    public function create()
    {
        // $this->authorize('admin_university_create');

        $data = [
            'pageTitle' => trans('admin/main.universities_new_page_title'),
        ];

        return view('admin.universities.create', $data);
    }

    public function store(Request $request)
    {
        // $this->authorize('admin_university_create');

        $this->validate($request, [
            'name' => 'required|min:3|max:64|unique:universities,name',
            'city' => 'required|min:2|max:64',
            'country' => 'required|min:2|max:64',
            'picture' => 'nullable|image|max:2048', // 2MB max size
        ]);

        $data = $request->all();

        if ($request->hasFile('picture')) {
            $data['picture'] = $request->file('picture')->store('universities', 'public');
        }

        University::create($data);

        Cache::forget('sections');

        return back()->with('success', 'University created successfully.');
    }

    public function edit($id)
    {
        $university = University::findOrFail($id);

        $data = [
            'pageTitle' => trans('admin/main.edit'),
            'university' => $university,
        ];

        return view('admin.universities.create', $data);
    }

    public function update(Request $request, $id)
    {
        // $this->authorize('admin_university_edit');

        $university = University::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|min:3|max:64|unique:universities,name,' . $id,
            'city' => 'required|min:2|max:64',
            'country' => 'required|min:2|max:64',
            'picture' => 'nullable|image|max:2048', // 2MB max size
        ]);

        $data = $request->all();

        if ($request->hasFile('picture')) {
            // Delete the old picture if it exists
            if ($university->picture) {
                Storage::disk('public')->delete($university->picture);
            }
            $data['picture'] = $request->file('picture')->store('pictures', 'public');
        }

        $university->update($data);

        Cache::forget('sections');

        return back()->with('success', 'University updated successfully.');
    }

    public function destroy($id)
    {
        // $this->authorize('admin_university_delete');

        $university = University::findOrFail($id);

        if ($university->picture) {
            Storage::disk('public')->delete($university->picture);
        }

        $university->delete();

        return back()->with('success', 'University deleted successfully.');
    }

    public function storeMajor(Request $request, $universityId)
    {
        $majorId = $request->input('major_id');
        $departmentId = $request->input('department_id');

        $university = University::findOrFail($universityId);

        // Attach the major to the university
        $university->majors()->attach($majorId, ['department_id' => $departmentId]);

        return response()->json(['success' => true, 'message' => 'Major added successfully!']);
    }
}
