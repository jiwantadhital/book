<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

    return $request->user();
});
Route::post('/register', [\App\Http\Controllers\API\AuthController::class,'register']);
Route::post('/login', [\App\Http\Controllers\API\AuthController::class,'login']);
Route::get('/send-sms-notification', [\App\Http\Controllers\NotificationController::class, 'sendSmsNotificaition']);
Route::put('/user/{id}',[\App\Http\Controllers\API\AuthController::class,'updatePhone']);

//Route::post('login', [\App\Http\Controllers\API\APIController::class, 'login']);
//Route::get('notice',[\App\Http\Controllers\API\APIController::class,'notice']);
//Route::Post('notice_save',[\App\Http\Controllers\API\APIController::class,'notice_save']);


//notices
Route::get('/notices/showAll', [\App\Http\Controllers\backend\SemesterController::class, 'showAllNotices']);


//subjects 
Route::get('/subjects/showAll/{id}', [\App\Http\Controllers\backend\SubjectController::class, 'showAll']);
//syllabus
Route::get('/syllabus/showAll/{id}', [\App\Http\Controllers\backend\SyllabusController::class, 'showAll']);
//chapters
Route::get('/chapters/showAll/{id}', [\App\Http\Controllers\backend\ChapterController::class, 'showAll']);
//notes
Route::get('/notes/showAll/{id}', [\App\Http\Controllers\backend\NotesController::class, 'showAll']);
//questionbanks
Route::get('/question/showAll/{id}/{year_id}', [\App\Http\Controllers\backend\QuestionbankController::class, 'showAll']);
//year
Route::get('/questionyear/showAll', [\App\Http\Controllers\backend\QuestionyearController::class, 'showAll']);
//semester
Route::get('/semesters/showAll', [\App\Http\Controllers\backend\SemesterController::class, 'showAll']);

Route::group(['middleware'=>'auth:sanctum'],function(){
});
