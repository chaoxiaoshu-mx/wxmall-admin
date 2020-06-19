<?php

use Illuminate\Http\Request;
use App\Model\Swiper;
use App\Model\CateItem;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/swiper', function () {
	return Swiper::all();
});
Route::get('/cate_item', function () {
	return CateItem::all();
});
