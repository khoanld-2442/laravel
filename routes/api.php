<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login', 'Api\LoginApiController@login');
Route::get('user', 'Api\LoginApiController@index');
Route::delete('user/{id}', 'Api\LoginApiController@delete');
Route::post('add-user', 'Api\LoginApiController@add');
Route::get('get-user/{id}', 'Api\LoginApiController@show');