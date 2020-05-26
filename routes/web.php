<?php

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

// public
Route::group(
    [
    ],
    function () {
        // debug
        Route::any('debug/session', 'DebugController@session');
        Route::any('debug/login', 'DebugController@login');
        //
        Route::get('/admin/login', 'AdminController@loginPage')->name('adminLogin');
    }
);

// 后台页面
Route::group(
    [
        'middleware' => 'auth:adminpage',
        'prefix' => 'admin'
    ],
    function () {
        Route::get('/', 'AdminController@index')->name('adminIndex');
    }
);

// 用户个人中心接口
Route::group(
    [
        'middleware' => 'auth:person',
        'prefix' => 'person'
    ],
    function () {
        Route::post('info', 'UserController@info');
    }
);

// 超管接口
Route::group(
    [
        'middleware' => 'auth:super',
        'prefix' => 'super'
    ], 
    function () {
    }
);

