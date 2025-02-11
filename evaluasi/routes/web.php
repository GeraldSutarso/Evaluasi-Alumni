<?php

use App\Http\Controllers\Admin\LayananQuestionsController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\TracerQuestionsController;


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
Route::post('/tracer-study/import', [EvaluationController::class, 'importTracerStudy'])->name('tracer.study.import');

Route::middleware(['admin'])->prefix('admin')->group(function(){
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/home', [AdminController::class, 'index'])->name('admin.index2');
;
});
Route::middleware(['admin'])->prefix('admin/layanan-alumni')->group(function(){
    Route::resource('questions', LayananQuestionsController::class)->names('layanan.questions');

    Route::post('questions/{question}/options', [LayananQuestionsController::class, 'addOption'])
         ->name('layanan.questions.options.store');
    Route::put('options/{option}', [LayananQuestionsController::class, 'updateOption'])
         ->name('layanan.questions.options.update');
    Route::delete('options/{option}', [LayananQuestionsController::class, 'destroyOption'])
         ->name('layanan.questions.options.destroy');
});

Route::middleware(['admin'])->prefix('admin/tracer-study')->group(function(){
    Route::resource('questions', TracerQuestionsController::class)->names('tracer.questions');

    Route::post('questions/{question}/options', [TracerQuestionsController::class, 'addOption'])
         ->name('tracer.questions.options.store');

    Route::put('options/{option}', [TracerQuestionsController::class, 'updateOption'])
         ->name('tracer.questions.options.update');
    
    Route::delete('options/{option}', [TracerQuestionsController::class, 'destroyOption'])
         ->name('tracer.questions.options.destroy');
});