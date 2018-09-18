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

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');*/

/*Route::get('/product', ['uses'=>'ProductController@show', 'as'=>'product']);*/
Route::post('/product', ['uses'=>'ProductController@store', 'as'=>'product',
    'middleware'=>'auth.jwt']);

Route::post('/user',[
    'uses'=> 'UserController@signup'
]);
Route::post('/user',[
    'uses'=> 'UserController@signin'
]);