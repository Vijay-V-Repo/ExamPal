<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Auth::routes();

Route::middleware('auth')->group(function (){
    Route::resource('exams', \App\Http\Controllers\ExamController::class);

    Route::post('students/assign-exam', [\App\Http\Controllers\StudentController::class, 'assign_exam'])->name('students.assign_exam');
    Route::resource('students', \App\Http\Controllers\StudentController::class)->only(['index', 'show']);

    Route::get('start-exam/{exam}', [\App\Http\Controllers\SubmissionController::class, 'exam_view'])->name('exam.start');
    Route::post('submissions/start-exam', [\App\Http\Controllers\SubmissionController::class, 'start_exam'])->name('submission.start_exam');
    Route::post('submissions/current-question', [\App\Http\Controllers\SubmissionController::class, 'current_question_updater'])->name('submission.current_question');
    Route::post('submission/bookmarks', [\App\Http\Controllers\SubmissionController::class, 'bookmark'])->name('submission.bookmark');
    Route::post('submissions/question-submission', [\App\Http\Controllers\SubmissionController::class, 'question_submission'])->name('submission.question_submission');
    Route::post('submissions/submit', [\App\Http\Controllers\SubmissionController::class, 'exam_submission'])->name('submission.exam_submission');
});

Route::get('/{view}', function ($view){
    return view($view);
});