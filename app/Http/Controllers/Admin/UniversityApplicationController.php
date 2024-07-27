<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\University;
use App\Models\Major;
use App\Models\Department;
use App\Models\UniversityMajor;
use App\models\UniversityApplication;
use App\Models\Country;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class UniversityApplicationController extends Controller
{
    public function index()
    {
        $universities = UniversityApplication::orderBy('created_at', 'asc')->paginate(10);

        foreach ($universities as $university) {
            $university_major = UniversityMajor::find($university->university_major_id);

            $university->university = $university_major->university;
            $university->department  = $university_major->department;
            $university->major = $university_major->major;
        }

        $data = [
            'pageTitle' => trans('admin/pages/universities.university_application'),
            'universities' => $universities,
        ];

        return view('admin.universities.application.index', $data);
    }

    // public function show($id)
    // {
    //     $university = University::with(['majors.departments'])->findOrFail($id);
    //     $allMajors = Major::all();
    //     $allDepartments = Department::all();
    //     $universityMajors = UniversityMajor::with('department')->with('major')->where('university_id', $id)->get();

    //     $data = [
    //         'pageTitle' => trans('admin/main.university_detail'),
    //         'university' => $university,
    //         'allMajors' => $allMajors,
    //         'allDepartments' => $allDepartments,
    //         'universityMajors' => $universityMajors,
    //     ];

    //     return view('admin.universities.show', $data);
    // }

    public function create()
    {
        $countries = Country::all();
        $cities = City::all();
        $universities = University::all();
        $departments = Department::all();
        $majors = Major::all();

        $data = [
            'pageTitle' => trans('admin/main.universities_new_page_title'),
            'countries' => $countries,
            'cities' => $cities,
            'universities' => $universities,
            'departments' => $departments,
            'majors' => $majors,
        ];

        return view('admin.universities.application.create', $data);
    }

    public function store(Request $request)
    {
        // $this->authorize('admin_university_create');

        $this->validate($request, [
            'university_id' => 'required|exists:universities,id',
            'major_id' => 'required|exists:majors,id',
            'department_id' => 'required|exists:departments,id',
            // 'country_id' => 'required|exists:countries,id',
            // 'city_id' => 'required|exists:cities,id',
            // 'picture' => 'nullable|image|max:2048',
            // 'individual_application_quota' => 'nullable|integer',
            'individual_application_required_documents' => 'nullable|string',
            // 'individual_application_quota_transfer' => 'nullable|integer',
            // 'united_distribution_quota_total' => 'nullable|integer',
            // 'united_distribution_quota_total_s1' => 'nullable|integer',
            // 'united_distribution_quota_total_s2' => 'nullable|integer',
            // 'united_distribution_quota_total_s3' => 'nullable|integer',
            // 'united_distribution_quota_total_s4' => 'nullable|integer',
            // 'united_distribution_quota_total_s5' => 'nullable|integer',
            'english_program' => 'nullable|boolean',
            '5_graduate_system_can_apply' => 'nullable|boolean',
        ]);

        $data = $request->all();

        $universitymajor = UniversityMajor::where('university_id', $data["university_id"])
            ->where('major_id', $data["major_id"])
            ->where('department_id', $data["department_id"])
            ->first();

        if (!$universitymajor) {
            $universitymajor = UniversityMajor::create([
                'university_id' => $data["university_id"],
                'major_id' => $data["major_id"],
                'department_id' => $data["department_id"]
            ]);
        }

        $data["university_major_id"] = $universitymajor->id;
        $data["english_program"] = $request["english_program"] ? 1 : 0;
        $data["5_graduate_system_can_apply"] = $request["5_graduate_system_can_apply"] ? 1 : 0;

        UniversityApplication::create($data);

        return back()->with('success', 'University Application created successfully.');
    }

    public function edit($id)
    {
        $university = UniversityApplication::findOrFail($id);

        $data = [
            'pageTitle' => trans('admin/main.edit'),
            'university' => $university
        ];

        return view('admin.universities.application.create', $data);
    }

    public function update(Request $request, $id)
    {
        $university = UniversityApplication::findOrFail($id);

        $this->validate($request, [
            'individual_application_required_documents' => 'nullable|string',
            'english_program' => 'nullable|boolean',
            '5_graduate_system_can_apply' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data["english_program"] = $request["english_program"] ? 1 : 0;
        $data["5_graduate_system_can_apply"] = $request["5_graduate_system_can_apply"] ? 1 : 0;

        $university->update($data);

        return back()->with('success', 'University updated successfully.');
    }

    public function destroy($id)
    {
        $university = UniversityApplication::findOrFail($id);
        $university->delete();

        return back()->with('success', 'University Application deleted successfully.');
    }
}
