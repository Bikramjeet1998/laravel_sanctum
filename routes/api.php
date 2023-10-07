<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;


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

//
//Route::group(['middleware' => 'auth:sanctum'], function () {
//    Route::get('getUser',[userController::class,'userData']);
//});

Route::group(['middleware' => 'custom.auth'], function () {
    Route::get('getUser',[UserController::class,'userData']);
});



Route::post('/login',[UserController::class,'index']);
// Route::post('/check',[UserController::class,'check']);
//Route::get('getUser',[userController::class,'userData']);

Route::post('verify-user', [UserController::class, 'verifyUser'])->middleware('encrypt');
