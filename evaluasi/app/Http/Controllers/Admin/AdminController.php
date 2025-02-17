<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
use App\Imports\LayananAlumniImport;
use App\Imports\TracerStudyImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;



class AdminController extends Controller

{
    public function index(Request $request)
    {
        Session::put('admin_alumni', true);

        // Existing chart data for survey questions...
        $layananAlumniQuestions = LayananAlumniQuestion::where('type', 'Survey')->get();
        $layananAlumniChartData = $this->prepareChartData($layananAlumniQuestions, LayananAlumniResponse::class, [1, 2, 3, 4]);

        $tracerStudyQuestions = TracerStudyQuestion::where('type', 'Survey')->get();
        $tracerStudyChartData = $this->prepareChartData($tracerStudyQuestions, TracerStudyResponse::class, [1, 2, 3, 4, 5]);

        $tracerQuestions = TracerStudyQuestion::where('type', 'Tracer')->get();
        $tracerPieChartData = $this->preparePieChartData($tracerQuestions, TracerStudyResponse::class);

        // --- New Part for Feedback Responses ---

        // Feedback for Layanan Alumni: get questions where type is 'Feedback'
        $feedbackLayananQuestions = LayananAlumniQuestion::where('type', 'Feedback')->get();
        $feedbackLayanan = [];
        foreach ($feedbackLayananQuestions as $question) {
            // Load responses along with the alumni relationship
            $responses = LayananAlumniResponse::with('alumni')->where('question_id', $question->id)->get();
            // Only include if there are responses
            if ($responses->isNotEmpty()) {
                $feedbackLayanan[] = [
                    'question'  => $question->text,
                    'responses' => $responses
                ];
            }
        }

        // Feedback for Tracer Study: get questions where type is 'Feedback'
        $feedbackTracerQuestions = TracerStudyQuestion::where('type', 'Feedback')->get();
        $feedbackTracer = [];
        foreach ($feedbackTracerQuestions as $question) {
            $responses = TracerStudyResponse::with('alumni')->where('question_id', $question->id)->get();
            if ($responses->isNotEmpty()) {
                $feedbackTracer[] = [
                    'question'  => $question->text,
                    'responses' => $responses
                ];
            }
        }

        // Combine all chart and feedback data into an array
        $chartData = [
            'layananAlumni'   => collect($layananAlumniChartData),
            'tracerStudy'     => collect($tracerStudyChartData),
            'tracerPie'       => collect($tracerPieChartData),
            'feedbackLayanan' => collect($feedbackLayanan),
            'feedbackTracer'  => collect($feedbackTracer),
        ];

        return view('admin.landing', compact('chartData'));
    }

    private function prepareChartData($questions, $responseModel, $values)
    {
        $chartData = [];
        foreach ($questions as $question) {
            $responses = $responseModel::where('question_id', $question->id)
                ->select('response_value', DB::raw('COUNT(*) as count'))
                ->groupBy('response_value')
                ->pluck('count', 'response_value');

            // Ensure all response values are present
            $counts = array_map(fn($val) => $responses[$val] ?? 0, $values);

            $chartData[] = [
                'question' => $question->text,
                'labels' => $values,
                'data' => $counts,
            ];
        }

        return $chartData;
    }
    
    private function preparePieChartData($questions, $responseModel)
    {
        $chartData = [];
        foreach ($questions as $question) {
            $responses = $responseModel::where('question_id', $question->id)
                ->select('response_value', DB::raw('COUNT(*) as count'))
                ->groupBy('response_value')
                ->pluck('count', 'response_value');

            $chartData[] = [
                'question' => $question->text,
                'labels' => $responses->keys()->toArray(),
                'data' => $responses->values()->toArray(),
            ];
        }
        return $chartData;
    }


    
}
