<?php

// 后台页面
Route::group(
    [
        'middleware' => 'adminPage',
    ],
    function () {
        Route::get('/', 'AdminController@index')->name('adminIndex');
    }
);

// 用户个人中心接口
Route::group(
    [
        'middleware' => 'adminApi:user',
        'prefix' => 'user'
    ],
    function () {
        Route::post('info', 'UserController@info');
    }
);

// 超管接口
Route::group(
    [
        'middleware' => 'adminApi:super',
        'prefix' => 'super'
    ], 
    function () {
    }
);