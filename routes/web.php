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
		Route::get('/vericode/image', 'VericodeController@genImage');
		Route::get('/admin/login', 'AdminController@loginPage')->name('adminLogin');
		Route::post('/admin/checkLogin', 'AdminController@checkLogin');
		Route::post('/admin/login', 'AdminController@login');
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
		Route::get('/main', 'AdminController@main');
		Route::get('/logout', 'AdminController@logout');

		// 用户
		Route::get('/user', 'UserController@userPage');
		Route::post('/user/info', 'UserController@info');
		Route::post('/user/modifyPass', 'UserController@modifyPassword');

		Route::post('/user/list', 'UserController@lists');
		Route::post('/user/add', 'UserController@add');
		Route::post('/user/edit', 'UserController@edit');
		Route::post('/user/del', 'UserController@del');
		Route::post('/user/changeGroup', 'UserController@changeGroup');
		Route::post('/user/ban', 'UserController@ban');
		// 用户组
		Route::get('/usergroup', 'UserGroupController@usergroupPage');
		Route::post('/usergroup/list', 'UserGroupController@lists');
		Route::post('/usergroup/add', 'UserGroupController@add');
		Route::post('/usergroup/edit', 'UserGroupController@edit');
		Route::post('/usergroup/del', 'UserGroupController@del');
		Route::post('/usergroup/character/list', 'UserGroupController@listCharacter');
		Route::post('/usergroup/character/add', 'UserGroupController@addCharacter');
		Route::post('/usergroup/character/del', 'UserGroupController@delCharacter');
		// 角色
		Route::get('/character', 'CharacterController@characterPage');
		Route::post('/character/list', 'CharacterController@lists');
		Route::post('/character/add', 'CharacterController@add');
		Route::post('/character/edit', 'CharacterController@edit');
		Route::post('/character/del', 'CharacterController@del');
		Route::post('/character/auth/all', 'CharacterController@allCharacterAuth');
		Route::post('/character/auth/list', 'CharacterController@listCharacterAuth');
		Route::post('/character/auth/add', 'CharacterController@addCharacterAuth');
		Route::post('/character/auth/del', 'CharacterController@delCharacterAuth');

		Route::get('/accountSetting', 'UserController@accountSettingPage');

	}
);



