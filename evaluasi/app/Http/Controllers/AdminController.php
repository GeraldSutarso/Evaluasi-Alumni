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

class AdminController extends Controller
{
    //
    public function index(Request $request)
    {
        // Check if 'admin_alumni' session key is true
        if ($request->session()->get('admin_alumni') === true) {
            // Proceed to admin_dashboard view
            return view('admin_dashboard');
        }

        // Redirect to home view if not an admin
        return redirect()->route('home');
    }
}
