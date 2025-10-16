<?php

use App\Http\Controllers\AssessmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/upload', [AssessmentController::class, 'showForm']);
Route::post('/upload', [AssessmentController::class, 'uploadExcel'])->name('upload.excel');

Route::get('reports', [AssessmentController::class, 'index'])->name('reports.index');
Route::get('reports/upload', [AssessmentController::class, 'uploadForm'])->name('reports.uploadForm');
Route::post('reports/upload', [AssessmentController::class, 'upload'])->name('reports.upload');