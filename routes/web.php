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
		//
		Route::get('/admin/login', 'AdminController@loginPage')->name('adminLogin');
	}
);

// admin
Route::group(
	[
		'middleware' => 'adminAuth',
		'prefix' => 'admin'
	],
	function () {
		Route::get('/', 'AdminController@index')->name('adminIndex');
	}
);



