<?php


Route::group(['middleware' => 'auth.admin'], function () {
	Route::get('/index', 'IndexController@index');
});

Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
Route::post('login', 'LoginController@login');
Route::post('logout', 'LoginController@logout');

Route::group(['prefix' => 'home', 'namespace' => 'Home'], function() {
	Route::resource('/swiper', 'SwiperController');
	Route::post('/swiper/upload', 'SwiperController@upload');
});
