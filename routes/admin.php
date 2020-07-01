<?php


Route::group(['middleware' => 'auth.admin'], function () {
	Route::get('/index', 'IndexController@index');
});

Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
Route::post('login', 'LoginController@login');
Route::post('logout', 'LoginController@logout');

Route::group(['prefix' => 'home', 'namespace' => 'Home'], function() {
	Route::resource('/swiper', 'SwiperController');
	Route::resource('/cate_item', 'CateItemController');
	Route::resource('/floor', 'FloorController');
	Route::resource('/floorlist', 'FloorListController');

});

Route::group(['prefix' => 'product', 'namespace' => 'Product'], function() {
	Route::resource('/category', 'ProductCategoryController');
});