<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SyllabusTopic;

class SyllabusTopicController extends Controller
{
    // public function show($syllabus_id)
    // {
    //     $topics = SyllabusTopic::where('syllabus_id', $syllabus_id)->get();
    //     return view('admin.syllabus.show', compact('topics'));
    // }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'syllabus_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $topic = SyllabusTopic::create($validatedData);

        return response()->json(['success' => true, 'topic' => $topic]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $topic = SyllabusTopic::findOrFail($id);
        $topic->update($validatedData);

        return response()->json(['success' => true, 'topic' => $topic]);
    }

    public function destroy($id)
    {
        $topic = SyllabusTopic::findOrFail($id);
        $topic->delete();

        return response()->json(['success' => true]);
    }
}
