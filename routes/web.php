<?php

use App\Http\Controllers\laravel_example\UserManagement;
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

$controller_path = 'App\Http\Controllers';
// //Login route
Route::get('/auth/login-basic', $controller_path . '\authentications\LoginBasic@index')->name('user-login');

Route::post('/auth/login-basic', $controller_path . '\authentications\LoginBasic@loginSubmit')->name('login-submit');

Route::post('auth/logout', $controller_path . '\authentications\LoginBasic@logout')->name('user-logout');
//Login admin
Route::get('/auth/login-cover', $controller_path . '\authentications\LoginCover@index')->name('auth-login-cover');

//Admin Route
Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'admin']], function () use ($controller_path) {;

});

//User Route
Route::group(['prefix' => '/', 'middleware' => 'admin'], function () use ($controller_path) {
    Route::get('/', $controller_path . '\dashboard\Analytics@index')->name('dashboard-analytics');
    Route::post('/info-save', $controller_path . '\info\InfoController@store')->name('info-save');
    Route::post('/excel-upload', $controller_path . '\createfile\CreateFileController@excel')->name('excel-upload');
    //Tồn kho
    Route::get('/kho', $controller_path . '\storage\StorageController@index')->name('kho');
    Route::delete('/kho-delete/{id}', $controller_path . '\storage\StorageController@destroy');
    Route::post('/kho-update/{id}', $controller_path . '\storage\StorageController@update');
    Route::post('/kho-save', $controller_path . '\storage\StorageController@store')->name('kho-save');
    Route::post('/kho-excel', $controller_path . '\storage\StorageController@excelsave')->name('kho-excel');
    Route::get('/api/storage-local/{user_id}', $controller_path . '\storage\StorageController@getStorageByUserId');

    //Thay thế dòng máy
    Route::resource('/replace-phone', $controller_path . '\phonereplace\PhoneReplaceController');

    Route::post('/replace-phone-excel', $controller_path . '\phonereplace\PhoneReplaceController@excelsave')->name('phone-excel');
    Route::get('/api/replace-phone/{user_id}', $controller_path . '\phonereplace\PhoneReplaceController@showid');

    Route::get('/download', function () {
        $file_path = public_path('assets/excel/upload kho.xlsx');
        return response()->download($file_path);
    });

    Route::get('/download-phone', function () {
        $file_path = public_path('assets/excel/thay dong may.xlsx');
        return response()->download($file_path);
    });

});

// laravel example
Route::get('/laravel/user-management', [UserManagement::class, 'UserManagement'])->name('laravel-example-user-management');
Route::resource('/user-list', UserManagement::class);
