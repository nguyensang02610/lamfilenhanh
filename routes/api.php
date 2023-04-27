<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\laravel_example\UserManagement;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InfoController;
use App\Http\Controllers\Api\StorageController;
use App\Http\Controllers\Api\PhoneReplaceController;
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
//Route Login
Route::group(['middleware' => 'cors'], function() {
    Route::post('user/login', [AuthController::class, 'login']);
});

//User Route
Route::group(['middleware' => ['auth:api','cors']], function(){
    Route::resource('info', InfoController::class);
    Route::resource('storage', StorageController::class);
    Route::resource('phone-replace', PhoneReplaceController::class);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});