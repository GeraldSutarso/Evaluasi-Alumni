<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TracerStudyQuestion;



class TracerQuestionsController extends Controller

{
    public function index(Request $request)
    {
        // Get filter from request
        $type = $request->get('type');
         // Get unique types from the database
        // $types = TracerStudyQuestion::select('type')->distinct()->pluck('type');
        // Fetch questions, optionally filtered by type
        $query = TracerStudyQuestion::with('options');
        if ($type) {
            $query->where('type', $type);
        }

        $questions = $query->paginate(10);

        // If the request is AJAX, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'questions' => view('admin.partials.questions', compact('questions'))->render(),
                'pagination' => view('admin.partials.pagination', compact('questions'))->render(),
            ]);
        }

        // Otherwise, return the full view
        return view('admin.tracerQuestions', compact('questions'
        // ,'types'
        ));

    }


    public function store(Request $request)
    {
        // Validate and create a new question
        $request->validate([
            'text' => 'required|string|max:1000',
            'type' => 'required|string|max:50',
        ]);

        $question = TracerStudyQuestion::create($request->all());
        return response()->json(['success' => true, 'question' => $question]);
    }

    public function edit($id)
    {
        // Retrieve the question by ID
        $question = TracerStudyQuestion::findOrFail($id);
    
        // Return the question data as a JSON response
        return response()->json(['success' => true, 'question' => $question]);
    }
    

    public function update(Request $request, $id)
    {
        // Validate and update the question
        $request->validate([
            'text' => 'required|string|max:1000',
            'type' => 'required|string|max:50',
        ]);

        $question = TracerStudyQuestion::findOrFail($id);
        $question->update($request->all());
        return response()->json(['success' => true, 'question' => $question]);
    }

    public function destroy($id)
    {
        // Delete a question
        $question = TracerStudyQuestion::findOrFail($id);
        $question->delete();
        return response()->json(['success' => true]);
    }
}