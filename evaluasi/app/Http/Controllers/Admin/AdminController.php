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
    
        // Fetch Layanan Alumni survey questions (Bar Chart)
        $layananAlumniQuestions = LayananAlumniQuestion::where('type', 'Survey')->get();
        $layananAlumniChartData = $this->prepareChartData($layananAlumniQuestions, LayananAlumniResponse::class, [1, 2, 3, 4]); // Values 1-4
    
        // Fetch Tracer Study survey questions (Bar Chart)
        $tracerStudyQuestions = TracerStudyQuestion::where('type', 'Survey')->get();
        $tracerStudyChartData = $this->prepareChartData($tracerStudyQuestions, TracerStudyResponse::class, [1, 2, 3, 4, 5]); // Values 1-5
    
        // Fetch Tracer Study survey questions (Pie Chart)
        $tracerQuestions = TracerStudyQuestion::where('type', 'Tracer')->get();
        $tracerPieChartData = $this->preparePieChartData($tracerQuestions, TracerStudyResponse::class);
    
        // Combine chart data
        $chartData = [
            'layananAlumni' => collect($layananAlumniChartData), // Bar Chart
            'tracerStudy' => collect($tracerStudyChartData), // Bar Chart
            'tracerPie' => collect($tracerPieChartData), // Pie Chart
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
