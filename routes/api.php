<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'App\Http\Controllers\AuthController@getMethodLogin');
    Route::post('logout', 'App\Http\Controllers\AuthController@getMethodLogout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@getMethodRefresh');
    Route::get('me', 'App\Http\Controllers\AuthController@getMethodMe');
    Route::post('register', 'App\Http\Controllers\AuthController@getMethodRegister');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'account'
], function ($router) {
    Route::get('users', 'App\Http\Controllers\UserController@index');
    Route::get('users/{id}', 'App\Http\Controllers\UserController@show');
    Route::put('users/{id}', 'App\Http\Controllers\UserController@update');
    Route::delete('users/{id}', 'App\Http\Controllers\UserController@destroy');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'store'
], function ($router) {
    //Comment paths
    Route::get('comments', 'App\Http\Controllers\CommentController@index');
    Route::post('comments','App\Http\Controllers\CommentController@store');
    Route::get('comment/{id}', 'App\Http\Controllers\CommentController@show');
    Route::put('comment/{id}', 'App\Http\Controllers\CommentController@update');
    Route::delete('comment/{id}', 'App\Http\Controllers\CommentController@destroy');

    //Product paths
    Route::get('products', 'App\Http\Controllers\ProductController@index');
    Route::post('products', 'App\Http\Controllers\ProductController@store');
    Route::get('products/{id}', 'App\Http\Controllers\ProductController@show');
    Route::put('products/{id}', 'App\Http\Controllers\ProductController@update');
    Route::delete('products/{id}', 'App\Http\Controllers\ProductController@destroy');

    //Order paths
    Route::get('orders', 'App\Http\Controllers\OrderController@index');
    Route::post('orders','App\Http\Controllers\OrderController@store');
    Route::get('order/{id}', 'App\Http\Controllers\OrderController@show');
    Route::put('order/{id}', 'App\Http\Controllers\OrderController@update');
    Route::delete('order/{id}', 'App\Http\Controllers\OrderController@destroy');

    //Address paths
    Route::get('addresses', 'App\Http\Controllers\AddressController@index');
    Route::post('addresses','App\Http\Controllers\AddressController@store');
    Route::get('address/{id}', 'App\Http\Controllers\AddressController@show');
    Route::put('address/{id}', 'App\Http\Controllers\AddressController@update');
    Route::delete('address/{id}', 'App\Http\Controllers\AddressController@destroy');
});
