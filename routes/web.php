<?php

use App\Http\Controllers\Api\UserContoller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsymmetricController;

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
    return view('welcome');
});



Route :: get('form', [UserContoller::class,'login']);

Route::post('/check',[UserContoller::class,'check'])->name("check");
Route::get('/testing',[AsymmetricController::class,'testing']);

