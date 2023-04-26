<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\laravel_example\UserManagement;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InfoController;

Route::group(['middleware' => 'cors'], function() {
    Route::post('user/login', [AuthController::class, 'login']);
    Route::resource('info', InfoController::class);
    // Route::post('login', $controller_path . '\authentications\LoginBasic@loginSubmit')->name('login-submit');
    // Route::post('logout', $controller_path. '\authentications\LoginBasic@logout')->name('user-logout');
    // //Login admin
    // Route::get('login-cover', $controller_path . '\authentications\LoginCover@index')->name('auth-login-cover'); 
});


//User Route
Route::group(['middleware' => ['auth:api']], function(){
    
});
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