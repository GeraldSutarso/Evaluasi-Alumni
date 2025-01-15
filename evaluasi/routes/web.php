<?php

use App\Http\Controllers\EvaluationController;
use Illuminate\Support\Facades\Route;



Route::get('/', [EvaluationController::class, 'landingPage'])->name('landing');
//Fallback
Route::fallback(function () {
    return redirect('/');
    });

// Route::get('home', [EvaluationController::class, 'home'])->name('home'); 
// Route::get('/', [EvaluationController::class, 'home']); 
Route::get('evaluasi/layanan', [EvaluationController::class, 'layananAlumni'])->name('layanan-alumni');
Route::post('evaluasi/layanan', [EvaluationController::class, 'layananSubmit'])->name('layanan.submit');
Route::get('evaluasi/tracer-study', [EvaluationController::class, 'tracerStudy'])->name('tracer.study');
Route::post('evaluasi/tracer-study', [EvaluationController::class, 'tracerSubmit'])->name('tracer.submit');

Route::post('/layanan-alumni/import', [EvaluationController::class, 'importLayananAlumni'])->name('layanan.alumni.import');
