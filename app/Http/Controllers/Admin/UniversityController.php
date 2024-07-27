<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\University;
use App\Models\Major;
use App\Models\Department;
use App\Models\UniversityMajor;
use App\models\UniversityApplication;
use App\Models\Country;  // Ensure you have a Country model
use App\Models\City;     // Ensure you have a City model
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

    public function applicationIndex()
    {
        $universities = UniversityApplication::orderBy('created_at', 'asc')->paginate(10);

        foreach ($universities as $university) {
            $university_major = UniversityMajor::find($university->university_major_id);

            $university->university = $university_major->university;
            $university->department  = $university_major->department;
            $university->major = $university_major->major;
        }

        $data = [
            'pageTitle' => trans('admin/pages/universities.page_lists_title'),
            'universities' => $universities,
        ];

        return view('admin.universities.application.index', $data);
    }


    public function show($id)
    {
        $university = University::with(['majors.departments'])->findOrFail($id);
        $allMajors = Major::all();
        $allDepartments = Department::all();
        $universityMajors = UniversityMajor::with('department')->with('major')->where('university_id', $id)->get();

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

        $countries = Country::all();  // Fetch all countries
        $cities = City::all();        // Fetch all cities

        $data = [
            'pageTitle' => trans('admin/main.universities_new_page_title'),
            'countries' => $countries,
            'cities' => $cities,
        ];

        return view('admin.universities.create', $data);
    }

    public function store(Request $request)
    {
        // $this->authorize('admin_university_create');

        $this->validate($request, [
            'name' => 'required|min:3|max:64|unique:universities,name',
            'country_id' => 'required|exists:countries,id',  // Validate country_id
            'city_id' => 'required|exists:cities,id',        // Validate city_id
            'picture' => 'nullable|image|max:2048',          // 2MB max size
            'individual_application_quota' => 'nullable|integer',
            'individual_application_required_documents' => 'nullable|string',
            'individual_application_quota_transfer' => 'nullable|integer',
            'united_distribution_quota_total' => 'nullable|integer',
            'united_distribution_quota_total_s1' => 'nullable|integer',
            'united_distribution_quota_total_s2' => 'nullable|integer',
            'united_distribution_quota_total_s3' => 'nullable|integer',
            'united_distribution_quota_total_s4' => 'nullable|integer',
            'united_distribution_quota_total_s5' => 'nullable|integer',
            'english_program' => 'nullable|boolean',
            '5_graduate_system_can_apply' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data["english_program"]  = $request->english_program == 1 ? 1 : 0;
        $data["5_graduate_system_can_apply"]  = $request["5_graduate_system_can_apply"] == 1 ? 1 : 0;

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
        $countries = Country::all();  // Fetch all countries
        $cities = City::all();        // Fetch all cities

        $data = [
            'pageTitle' => trans('admin/main.edit'),
            'university' => $university,
            'countries' => $countries,
            'cities' => $cities,
        ];

        return view('admin.universities.create', $data);
    }

    public function update(Request $request, $id)
    {
        // $this->authorize('admin_university_edit');

        $university = University::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|min:3|max:64|unique:universities,name,' . $id,
            'country_id' => 'required|exists:countries,id',  // Validate country_id
            'city_id' => 'required|exists:cities,id',        // Validate city_id
            'picture' => 'nullable|image|max:2048',          // 2MB max size
            'individual_application_quota' => 'nullable|integer',
            'individual_application_required_documents' => 'nullable|string',
            'individual_application_quota_transfer' => 'nullable|integer',
            'united_distribution_quota_total' => 'nullable|integer',
            'united_distribution_quota_total_s1' => 'nullable|integer',
            'united_distribution_quota_total_s2' => 'nullable|integer',
            'united_distribution_quota_total_s3' => 'nullable|integer',
            'united_distribution_quota_total_s4' => 'nullable|integer',
            'united_distribution_quota_total_s5' => 'nullable|integer',
            'english_program' => 'nullable|boolean',
            '5_graduate_system_can_apply' => 'nullable|boolean',
        ]);

        $data = $request->all();

        if ($request->hasFile('picture')) {
            // Delete the old picture if it exists
            if ($university->picture) {
                Storage::disk('public')->delete($university->picture);
            }
            $data['picture'] = $request->file('picture')->store('universities', 'public');
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

        if ($university->majors()->where('major_id', $majorId)->wherePivot('department_id', $departmentId)->exists()) {
            return response()->json(['success' => false, 'message' => 'Major and department already exist for this university.']);
        }

        $university->majors()->attach($majorId, ['department_id' => $departmentId]);

        return response()->json(['success' => true, 'message' => 'Major added successfully!']);
    }
}
