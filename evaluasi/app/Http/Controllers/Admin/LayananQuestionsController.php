<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LayananAlumniQuestion;
use App\Models\LayananAlumniOption;

class LayananQuestionsController extends Controller
{
    public function index(Request $request)
    {
        // Get filter from request
        $type = $request->get('type');
         // Get unique types from the database
        // $types = LayananAlumniQuestion::select('type')->distinct()->pluck('type');
        // Fetch questions, optionally filtered by type
        $query = LayananAlumniQuestion::with('options');
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
        return view('admin.layananQuestions', compact('questions'
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

        $question = LayananAlumniQuestion::create($request->all());
        return response()->json(['success' => true, 'question' => $question]);
    }

    public function edit($id)
    {
        // Retrieve the question by ID
        $question = LayananAlumniQuestion::findOrFail($id);
    
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

        $question = LayananAlumniQuestion::findOrFail($id);
        $question->update($request->all());
        return response()->json(['success' => true, 'question' => $question]);
    }

    public function destroy($id)
    {
        // Delete a question
        $question = LayananAlumniQuestion::findOrFail($id);
        $question->delete();
        return response()->json(['success' => true]);
    }

    // Adds a new option to a question
    public function addOption(Request $request, $questionId)
    {
        $request->validate([
            'value' => 'required|string|max:1000'
        ]);

        $question = LayananAlumniQuestion::findOrFail($questionId);
        $option = $question->options()->create(['value' => $request->value]);

        return response()->json(['success' => true, 'option' => $option]);
    }

    // Updates an existing option
    public function updateOption(Request $request, $optionId)
    {
        $request->validate([
            'value' => 'required|string|max:1000'
        ]);

        $option = LayananAlumniOption::findOrFail($optionId);
        $option->update(['value' => $request->value]);

        return response()->json(['success' => true, 'option' => $option]);
    }

    // Deletes an option
    public function destroyOption($optionId)
    {
        $option = LayananAlumniOption::findOrFail($optionId);
        $question = $option->question;

        $option->delete();

        // Optionally, if the question now has no options, you might decide to remove it from display:
        // if ($question->options()->count() == 0) {
        //     $question->delete();
        // }

        return response()->json(['success' => true]);
    }

}
