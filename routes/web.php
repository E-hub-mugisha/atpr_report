<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IntakeController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ModuleEvaluationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TrainerController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/upload', [AssessmentController::class, 'showForm']);
Route::post('/upload', [AssessmentController::class, 'uploadExcel'])->name('upload.excel');

Route::get('reports', [AssessmentController::class, 'index'])->name('reports.index');
Route::get('reports/upload', [AssessmentController::class, 'uploadForm'])->name('reports.uploadForm');
Route::post('reports/upload', [AssessmentController::class, 'upload'])->name('reports.upload');

Route::resource('courses', CourseController::class);
Route::put('/courses/{course}/assign-trainer', [CourseController::class, 'assignTrainer'])->name('courses.assignTrainer');

Route::prefix('courses/{course}')->group(function () {
    Route::get('modules', [ModuleController::class, 'index'])->name('courses.modules.index');
    Route::post('modules', [ModuleController::class, 'store'])->name('courses.modules.store');
    Route::put('modules/{module}', [ModuleController::class, 'update'])->name('courses.modules.update');
    Route::delete('modules/{module}', [ModuleController::class, 'destroy'])->name('courses.modules.destroy');
});

Route::prefix('modules/{module}')->group(function () {
    Route::get('marks', [MarkController::class, 'index'])->name('modules.marks.index');
    Route::post('marks', [MarkController::class, 'store'])->name('modules.marks.store');
    Route::put('marks/{mark}', [MarkController::class, 'update'])->name('modules.marks.update');
    Route::delete('marks/{mark}', [MarkController::class, 'destroy'])->name('modules.marks.destroy');
});

Route::prefix('modules/{module}')->group(function () {

    Route::get('/lessons', [LessonController::class, 'index'])
        ->name('modules.lessons.index');

    Route::get('/lessons/{lesson}', [LessonController::class, 'show'])
        ->name('modules.lessons.show');

    Route::post('/lessons', [LessonController::class, 'store'])
        ->name('modules.lessons.store');

    Route::put('/lessons/{lesson}', [LessonController::class, 'update'])
        ->name('modules.lessons.update');

    Route::delete('/lessons/{lesson}', [LessonController::class, 'destroy'])
        ->name('modules.lessons.destroy');
});

Route::prefix('modules/{module}/lessons/{lesson}')->group(function () {
    Route::get('marks', [MarkController::class, 'index'])->name('lessons.marks.index');
    Route::post('marks', [MarkController::class, 'store'])->name('lessons.marks.store');
    Route::post('marks/store_complementary', [MarkController::class, 'storeComplementary'])->name('lessons.marks.storeComplementary');
    Route::put('marks/{mark}', [MarkController::class, 'update'])->name('lessons.marks.update');
    Route::post('marks/import', [MarkController::class, 'import'])->name('lessons.marks.import');
    Route::get('marks/export', [MarkController::class, 'export'])->name('lessons.marks.export');
});

Route::get('/marks', [MarkController::class, 'index'])->name('marks.index');
Route::delete('marks/delete/{id}', [MarkController::class, 'destroy'])
    ->name('lessons.marks.destroy');
Route::delete('/lessons/{module}/{lesson}/marks/delete-all', [MarkController::class, 'deleteAll'])->name('lessons.marks.deleteAll');


Route::resource('students', StudentController::class);
Route::get('/student/{id}/marks/view', [StudentController::class, 'viewMarks'])->name('student.marks.view');

Route::get('/students/marks/report', [StudentController::class, 'reportPage'])->name('students.report');
Route::post('/students/marks/report/generate', [StudentController::class, 'generateReport'])->name('students.report.generate');

Route::post('/students/marks/report/pdf', [StudentController::class, 'generatePdf'])->name('students.report.pdf');
Route::post('/students/marks/report/excel', [StudentController::class, 'generateExcel'])->name('students.report.excel');

Route::get('/final/report', [StudentController::class, 'finalReportPage'])->name('students.final.report');

Route::resource('trainers', TrainerController::class);

Route::get('/rtb/reports', [ReportController::class, 'index'])->name('rtb.reports');
Route::get('/reports/competent', [ReportController::class, 'competent'])->name('reports.competent');
Route::get('/reports/students', [ReportController::class, 'studentsInfo'])->name('reports.students');
Route::get('/reports/verification', [ReportController::class, 'verification'])->name('reports.verification');
Route::get('/export-verification', [ReportController::class, 'export']);

Route::resource('intakes', IntakeController::class);
   // routes/web.php
Route::get('/reports/atpr-excel', [ReportController::class, 'export']);

Route::get('/evaluations', [ModuleEvaluationController::class, 'index'])->name('evaluations.index');
Route::post('/evaluations/retrieve', [ModuleEvaluationController::class, 'retrieveStudent'])->name('evaluations.retrieve');
Route::get('/evaluation/create/{id}', [ModuleEvaluationController::class, 'create'])->name('evaluation.create');
Route::post('/evaluation/store', [ModuleEvaluationController::class, 'store'])->name('evaluation.store');
Route::get('/student/evaluations/{id}', [ModuleEvaluationController::class, 'show'])->name('evaluations.show');
Route::get('/evaluations/{id}/export', [ModuleEvaluationController::class, 'exportPdf'])->name('evaluations.export');
require __DIR__ . '/auth.php';
