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


//subjects 
Route::get('/subjects/showAll', [\App\Http\Controllers\backend\SubjectController::class, 'showAll']);

Route::group(['middleware'=>'auth:sanctum'],function(){
});
