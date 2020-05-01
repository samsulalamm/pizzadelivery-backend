<?php

use Illuminate\Http\Request;

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

Route::get('/get-pizzas', 'Api\ApiController@getPizzas');
Route::post('/store-order', 'Api\ApiController@storeOrder');
Route::get('/get-order-history', 'Api\ApiController@orderHistory');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
