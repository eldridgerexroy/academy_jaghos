<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class MajorController extends Controller
{
    public function index()
    {
        $majors = Major::orderBy('created_at', 'asc')->paginate(10);

        $data = [
            'pageTitle' => trans('admin/pages/majors.page_lists_title'),
            'majors' => $majors,
        ];

        return view('admin.majors.lists', $data);
    }

    public function create()
    {
        $data = [
            'pageTitle' => trans('admin/main.majors_new_page_title'),
        ];

        return view('admin.majors.create', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:128|unique:majors,name',
            'description' => 'required|min:2|max:1000',
        ]);

        $data = $request->all();

        Major::create($data);

        Cache::forget('sections');

        return back()->with('success', 'Major created successfully.');
    }

    public function edit($id)
    {
        $major = Major::findOrFail($id);

        $data = [
            'pageTitle' => trans('admin/main.edit'),
            'major' => $major,
        ];

        return view('admin.majors.create', $data);
    }

    public function update(Request $request, $id)
    {
        $major = Major::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|min:3|max:128|unique:majors,name,' . $id,
            'description' => 'required|min:2|max:1000',
        ]);

        $data = $request->all();

        $major->update($data);

        Cache::forget('sections');

        return back()->with('success', 'Major updated successfully.');
    }

    public function destroy($id)
    {
        $major = Major::findOrFail($id);
        $major->delete();

        return back()->with('success', 'Major deleted successfully.');
    }
}
