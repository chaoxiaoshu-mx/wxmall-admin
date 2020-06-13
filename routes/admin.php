<?php


Route::group(['middleware' => 'auth.admin'], function () {
	Route::get('/index', 'IndexController@index');
});

Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
Route::post('login', 'LoginController@login');
Route::post('logout', 'LoginController@logout');
