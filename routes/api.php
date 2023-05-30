<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CreateFileController;
use App\Http\Controllers\Api\CreateFileHistoryController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\InfoController;
use App\Http\Controllers\Api\PhoneReplaceController;
use App\Http\Controllers\Api\StorageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(['middleware' => 'cors'], function () {
    Route::post('user/login', [AuthController::class, 'login']);

    Route::get('/download', function () {
        $file_path = public_path('assets/excel/upload kho.xlsx');
        return response()->download($file_path);
    });

    Route::get('/download-phone', function () {
        $file_path = public_path('assets/excel/thay dong may.xlsx');
        return response()->download($file_path);
    });
});

//User Route
Route::group(['middleware' => 'cors'], function () {
    //Get info by user
    Route::resource('info', InfoController::class);
    Route::resource('storage', StorageController::class);
    Route::resource('phone-replace', PhoneReplaceController::class);
    Route::resource('history', CreateFileHistoryController::class);
    Route::get('home', [HomeController::class, 'index']);

    Route::get('find', [StorageController::class, 'findByType']);
    Route::post('upload-excel', [StorageController::class, 'ExcelUpload']);

    Route::post('new-notification', [CreateFileController::class, 'store']);

    Route::post('push-notification', [CreateFileController::class, 'storeAll']);

    Route::get('update-time-user/{time}', [CreateFileController::class, 'updateTime']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});