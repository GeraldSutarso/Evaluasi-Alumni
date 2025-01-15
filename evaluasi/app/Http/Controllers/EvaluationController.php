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
use App\Imports\LayananAlumniImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;


class EvaluationController extends Controller
{
    public function landingPage(Request $request)
    {
        // Fetch survey questions
        $surveyQuestions = LayananAlumniQuestion::where('type', 'Survey')->get();
        
        $chartData = [];
        foreach ($surveyQuestions as $question) {
            $responses = LayananAlumniResponse::where('question_id', $question->id)
                ->select('response_value', DB::raw('COUNT(*) as count'))
                ->groupBy('response_value')
                ->pluck('count', 'response_value');

            // Ensure responses for values 1, 2, 3, and 4 are always present
            $values = [1, 2, 3, 4];
            $counts = array_map(fn($val) => $responses[$val] ?? 0, $values);

            $chartData[] = [
                'question' => $question->text,
                'labels' => $values,
                'data' => $counts,
            ];
        }

        // Convert $chartData into a collection
        $chartData = collect($chartData);
        
        return view('landing', compact('chartData'));
    }

    

    public function layananAlumni()
    {
    
        // Group questions by type
        $groupedQuestions = LayananAlumniQuestion::all()->groupBy('type');
    
        // Fetch all options and map them by question_id for easy access in the view
        $options = LayananAlumniOption::all()->groupBy('question_id');
    
        // Pass data to the view
        return view('evaluasi.layanan', compact('groupedQuestions', 'options'));
    }
    

    public function layananSubmit(Request $request)
    {
        // Validate that responses are provided
        $request->validate([
            'responses' => 'required|array',
        ]);

        // Map question IDs (type = User) to LayananAlumni columns
        $userFieldMap = [
            1 => 'name',        // ID 1 maps to "name"
            2 => 'divisi',      // ID 2 maps to "divisi"
            3 => 'prodi',       // ID 3 maps to "prodi"
            4 => 'tahun_lulus', // ID 4 maps to "tahun_lulus"
        ];

        // Initialize data for layanan_alumnis table
        $layananAlumniData = [];

        // Prepare to save other responses
        $otherResponses = [];

        // Loop through submitted responses
        foreach ($request->responses as $questionId => $responseValue) {
            if (array_key_exists($questionId, $userFieldMap)) {
                // Map User-type question responses to layanan_alumnis columns
                $column = $userFieldMap[$questionId];
                $layananAlumniData[$column] = $responseValue;
            } else {
                // Collect other responses for LayananResponse table
                $otherResponses[] = [
                    'question_id' => $questionId,
                    'response_value' => $responseValue,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert into layanan_alumnis table
        $alumni = LayananAlumni::create($layananAlumniData);

        // Insert other responses into layanan_responses table, linked to the created alumni record
        foreach ($otherResponses as &$response) {
            $response['alumni_id'] = $alumni->id; // Associate with the alumni ID
        }
        LayananAlumniResponse::insert($otherResponses);

        // Redirect back with a success message
        return redirect()->route('landing')->with('success', 'Evaluasi layanan berhasil dikumpulkan.');
    }


    public function importLayananAlumni(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xlsx,csv|max:2048',
        ]);

        // Import the file
        Excel::import(new LayananAlumniImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data successfully imported!');
    }


    

    public function tracerStudy()
    {
    
        // Group questions by type
        $groupedQuestions = TracerStudyQuestion::all()->groupBy('type');
    
        // Fetch all options and map them by question_id for easy access in the view
        $options = TracerStudyOption::all()->groupBy('question_id');
    
        // Pass data to the view
        return view('tracer.study', compact('groupedQuestions', 'options'));
    }
    

    public function tracerSubmit(Request $request)
    {
        // Validate that responses are provided
        $request->validate([
            'responses' => 'required|array',
        ]);

        // Map question IDs (type = User) to LayananAlumni columns
        $userFieldMap = [
            1 => 'name',
            2 => 'prodi',
            3 => 'tahun_lulus',
            4 => 'department',
            5 => 'divisi',
            6 => 'tempat',
            7 => 'plant',

        ];

        // Initialize data for layanan_alumnis table
        $tracerStudyData = [];

        // Prepare to save other responses
        $otherResponses = [];

        // Loop through submitted responses
        foreach ($request->responses as $questionId => $responseValue) {
            if (array_key_exists($questionId, $userFieldMap)) {
                // Map User-type question responses to layanan_alumnis columns
                $column = $userFieldMap[$questionId];
                $tracerStudyData[$column] = $responseValue;
            } else {
                // Collect other responses for LayananResponse table
                $otherResponses[] = [
                    'question_id' => $questionId,
                    'response_value' => $responseValue,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert into layanan_alumnis table
        $alumni = TracerStudy::create($tracerStudyData);

        // Insert other responses into layanan_responses table, linked to the created alumni record
        foreach ($otherResponses as &$response) {
            $response['alumni_id'] = $alumni->id; // Associate with the alumni ID
        }
        TracerStudyResponse::insert($otherResponses);

        // Redirect back with a success message
        return redirect()->route('landing')->with('success', 'Evaluasi layanan berhasil dikumpulkan.');
    }
}