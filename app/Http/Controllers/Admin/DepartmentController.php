<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy('created_at', 'asc')->paginate(10);

        $data = [
            'pageTitle' => trans('admin/pages/departments.page_lists_title'),
            'departments' => $departments,
        ];

        return view('admin.departments.lists', $data);
    }

    public function create()
    {
        $data = [
            'pageTitle' => trans('admin/main.departments_new_page_title'),
        ];

        return view('admin.departments.create', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:128|unique:departments,name',
            'description' => 'required|min:2|max:1000',
        ]);

        $data = $request->all();

        Department::create($data);

        return back()->with('success', 'Department created successfully.');
    }

    public function edit($id)
    {
        $departments = Department::findOrFail($id);

        $data = [
            'pageTitle' => trans('admin/main.edit'),
            'departments' => $departments,
        ];

        return view('admin.departments.create', $data);
    }

    public function update(Request $request, $id)
    {
        $departments = Department::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|min:3|max:128|unique:departments,name,' . $id,
            'description' => 'required|min:2|max:1000',
        ]);

        $data = $request->all();

        $departments->update($data);

        return back()->with('success', 'Department updated successfully.');
    }

    public function destroy($id)
    {
        $departments = Department::findOrFail($id);
        $departments->delete();

        return back()->with('success', 'Department deleted successfully.');
    }
}
