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
Route::put('/payment/{id}',[\App\Http\Controllers\API\AuthController::class,'updatePayment']);

// google login
Route::post('/requestTokenGoogle',[\App\Http\Controllers\API\AuthController::class,'requestTokenGoogle']);

//update profile
Route::put('/update/profile/{id}',[\App\Http\Controllers\API\AuthController::class,'editProfile']);

//Route::post('login', [\App\Http\Controllers\API\APIController::class, 'login']);
//Route::get('notice',[\App\Http\Controllers\API\APIController::class,'notice']);
//Route::Post('notice_save',[\App\Http\Controllers\API\APIController::class,'notice_save']);
//email
Route::get('/sendemail', [\App\Http\Controllers\API\AuthController::class, 'basic_email']);
Route::post('/forgot/sendOtp', [\App\Http\Controllers\API\AuthController::class, 'sendOtp']);
Route::post('/forgot/resendOtp', [\App\Http\Controllers\API\AuthController::class, 'resedOtp']);
Route::post('/changePassword', [\App\Http\Controllers\API\AuthController::class, 'changePassword']);


 //notices
 Route::get('/notices/showAll', [\App\Http\Controllers\backend\SemesterController::class, 'showAllNotices']);
 Route::get('/notices/recent', [\App\Http\Controllers\backend\SemesterController::class, 'recentNotices']);

 Route::get('/notices/today', [\App\Http\Controllers\backend\SemesterController::class, 'todayNotices']);
 
 Route::get('/notices/thisWeek', [\App\Http\Controllers\backend\SemesterController::class, 'thisWeek']);
 

Route::group(['middleware'=>'auth:sanctum'],function(){
   

//colleges
Route::get('/institutes/showAll', [\App\Http\Controllers\backend\CollegeController::class, 'showAll']);

//college images
Route::get('/collegeImages/showAll/{id}', [\App\Http\Controllers\backend\CollegeController::class, 'imageShowAll']);
//comment
Route::get('/comments/showAll/{id}', [\App\Http\Controllers\backend\CommentController::class, 'showAll']);

//solutions
Route::get('/solutions/showAll/{id}/{year_id}', [\App\Http\Controllers\backend\SolutionController::class, 'showAll']);
//comments
Route::post('/getComment',[\App\Http\Controllers\backend\CommentController::class,'getComment']);
//problems
// Route::post('/getComment',[\App\Http\Controllers\backend\CommentController::class,'getComment']);

//profile
Route::get('/profile/getProfile/{id}', [\App\Http\Controllers\API\AuthController::class, 'getProfile']);

//subjects 
Route::get('/labs/showAll/{id}', [\App\Http\Controllers\backend\LabController::class, 'showAll']);
//labs
Route::get('/subjects/showAll/{id}', [\App\Http\Controllers\backend\SubjectController::class, 'showAll']);
//allsubjects
Route::get('/subjects/showSubjects', [\App\Http\Controllers\backend\SubjectController::class, 'showSubjects']);
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

//collegeyears
Route::get('/collegeYear/showAll', [\App\Http\Controllers\backend\CollegequestionController::class, 'collegeYear']);
//college questions
Route::get('/collegequestion/showAll/{id}/{collegeyear_id}', [\App\Http\Controllers\backend\CollegequestionController::class, 'showquestions']);
//semester
Route::get('/semesters/showAll', [\App\Http\Controllers\backend\SemesterController::class, 'showAll']);
//news
Route::get('/news/showAll', [\App\Http\Controllers\backend\NewsController::class, 'showAll']);
});

Route::get('/accountDelete', [App\Http\Controllers\HomeController::class, 'accountDelete'])->name('accountDelete');
Route::post('/storeAccount', [App\Http\Controllers\HomeController::class, 'store'])->name('store');