<?php

use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TrainerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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
    Route::put('marks/{mark}', [MarkController::class, 'update'])->name('lessons.marks.update');
    Route::delete('marks/{mark}', [MarkController::class, 'destroy'])->name('lessons.marks.destroy');
    Route::post('marks/import', [MarkController::class, 'import'])->name('lessons.marks.import');
    Route::get('marks/export', [MarkController::class, 'export'])->name('lessons.marks.export');
});

Route::resource('students', StudentController::class);
Route::get('/student/{id}/marks/view', [StudentController::class, 'viewMarks'])->name('student.marks.view');

Route::get('/students/marks/report', [StudentController::class, 'reportPage'])->name('students.report');
Route::post('/students/marks/report/generate', [StudentController::class, 'generateReport'])->name('students.report.generate');

Route::post('/students/marks/report/pdf', [StudentController::class, 'generatePdf'])->name('students.report.pdf');
Route::post('/students/marks/report/excel', [StudentController::class, 'generateExcel'])->name('students.report.excel');

Route::get('/final/report', [StudentController::class, 'finalReportPage'])->name('students.final.report');
Route::resource('trainers', TrainerController::class);
