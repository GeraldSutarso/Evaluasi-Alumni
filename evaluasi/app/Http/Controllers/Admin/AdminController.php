<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LayananAlumni;
use App\Models\LayananAlumniQuestion;
use App\Models\LayananAlumniResponse;
use App\Models\LayananAlumniOption;
use App\Models\TracerStudy;
use App\Models\TracerStudyQuestion;
use App\Models\TracerStudyResponse;
use App\Models\TracerStudyOption;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Session;


class AdminController extends Controller

{
    public function index(Request $request)
    {
        $questions = LayananAlumniQuestion::with('options')->get();
        return view('admin.layananQuestions', compact('questions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:600',
            'type' => 'required|string|max:50',
        ]);

        $question = LayananAlumniQuestion::create($request->all());
        return response()->json(['success' => true, 'question' => $question]);
    }

    public function edit($id)
    {
        $question = LayananAlumniQuestion::findOrFail($id);
        return response()->json(['success' => true, 'question' => $question]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'text' => 'required|string|max:600',
            'type' => 'required|string|max:50',
        ]);

        $question = LayananAlumniQuestion::findOrFail($id);
        $question->update($request->all());
        return response()->json(['success' => true, 'question' => $question]);
    }

    public function destroy($id)
    {
        $question = LayananAlumniQuestion::findOrFail($id);
        $question->delete();
        return response()->json(['success' => true]);
    }
}
