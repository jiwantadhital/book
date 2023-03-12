<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoticesController;
use App\Http\Controllers\backend\NewsController;
use App\Http\Controllers\backend\QuestionyearController;
use App\Http\Controllers\backend\SemesterController;
use App\Http\Controllers\backend\SubjectController;
use App\Http\Controllers\backend\SyllabusController;
use App\Http\Controllers\backend\QuestionbankController;
use App\Http\Controllers\backend\CollegeyearController;
use App\Http\Controllers\backend\CollegequestionController;
use App\Http\Controllers\backend\SolutionController;
use App\Http\Controllers\backend\LabController;
use App\Http\Controllers\backend\NotesController;
use App\Http\Controllers\backend\ChapterController;
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

Route::get('/', function () {
    return view('auth/login');
});
Auth::routes();
Route::group(['prefix'=>'/admin','as'=>'admin.'],function(){
    Route::post('upload', [NotesController::class,'uploadimage'])->name('ckeditor.upload');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('.home');
Route::resource('notice',NoticesController::class);
Route::resource('news',NewsController::class);
Route::resource('questionyear',QuestionyearController::class);
Route::resource('semester',SemesterController::class);
Route::resource('subject',SubjectController::class);
Route::resource('syllabus',SyllabusController::class);
Route::resource('questionbank',QuestionbankController::class);
Route::resource('collegeyear',CollegeyearController::class);
Route::resource('collegequestion',CollegequestionController::class);
Route::resource('solution',SolutionController::class);
Route::resource('lab',LabController::class);
Route::resource('chapter',ChapterController::class);
Route::resource('notes',NotesController::class);
    Route::get('chapter/getSubCategories/{id}', [ChapterController::class,'getSubCategories']);
    Route::get('chapter/{id}/getSubCategoriesedt/{ids}', [ChapterController::class,'getSubCategoriesedt']);

    Route::get('notes/getSubCategories/{id}', [NotesController::class,'getSubCategories']);
    Route::get('notes/getchapter/{id}', [NotesController::class,'getchapter']);
    Route::get('notes/{id}/getchapteredt/{idss}', [NotesController::class,'getchapteredt']);
    Route::get('notes/{id}/getSubCategoriesedt/{ids}', [NotesController::class,'getSubCategoriesedt']);

});
Route::get('admin/syllabus/getSubCategories/{id}', [SyllabusController::class,'getSubCategories']);
Route::get('admin/syllabus/{id}/getSubCategoriesedt/{ids}', [SyllabusController::class,'getSubCategoriesedt']);

Route::get('admin/questionbank/getSubCategories/{id}', [QuestionbankController::class,'getSubCategories']);
Route::get('admin/questionbank/{id}/getSubCategoriesedt/{ids}', [QuestionbankController::class,'getSubCategoriesedt']);


Route::get('admin/collegequestion/getSubCategories/{id}', [CollegequestionController::class,'getSubCategories']);
Route::get('admin/collegequestion/{id}/getSubCategoriesedt/{ids}', [CollegequestionController::class,'getSubCategoriesedt']);


Route::get('admin/solution/getSubCategories/{id}', [SolutionController::class,'getSubCategories']);
Route::get('admin/solution/{id}/getSubCategoriesedt/{ids}', [SolutionController::class,'getSubCategoriesedt']);

Route::get('admin/lab/getSubCategories/{id}', [LabController::class,'getSubCategories']);
Route::get('admin/lab/{id}/getSubCategoriesedt/{ids}', [LabController::class,'getSubCategoriesedt']);








