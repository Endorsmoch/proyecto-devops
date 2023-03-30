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
    Route::get('users', 'App\Http\Controllers\UserController@getMethodIndex');
    Route::get('users/{id}', 'App\Http\Controllers\UserController@getMethodShow');
    Route::put('users/{id}', 'App\Http\Controllers\UserController@getMethodUpdate');
    Route::delete('users/{id}', 'App\Http\Controllers\UserController@getMethodDestroy');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'store'
], function ($router) {
    //Comment paths
    Route::get('comments', 'App\Http\Controllers\CommentController@getMethodIndex');
    Route::post('comments','App\Http\Controllers\CommentController@getMethodStore');
    Route::get('comment/{id}', 'App\Http\Controllers\CommentController@getMethodShow');
    Route::put('comment/{id}', 'App\Http\Controllers\CommentController@getMethodUpdate');
    Route::delete('comment/{id}', 'App\Http\Controllers\CommentController@getMethodDestroy');

    //Product paths
    Route::get('products', 'App\Http\Controllers\ProductController@getMethodIndex');
    Route::post('products', 'App\Http\Controllers\ProductController@getMethodStore');
    Route::get('products/{id}', 'App\Http\Controllers\ProductController@getMethodShow');
    Route::put('products/{id}', 'App\Http\Controllers\ProductController@getMethodUpdate');
    Route::delete('products/{id}', 'App\Http\Controllers\ProductController@getMethodDestroy');

    //Order paths
    Route::get('orders', 'App\Http\Controllers\OrderController@getMethodIndex');
    Route::post('orders','App\Http\Controllers\OrderController@getMethodStore');
    Route::get('order/{id}', 'App\Http\Controllers\OrderController@getMethodShow');
    Route::put('order/{id}', 'App\Http\Controllers\OrderController@getMethodUpdate');
    Route::delete('order/{id}', 'App\Http\Controllers\OrderController@getMethodDestroy');

    //Address paths
    Route::get('addresses', 'App\Http\Controllers\AddressController@getMethodIndex');
    Route::post('addresses','App\Http\Controllers\AddressController@getMethodStore');
    Route::get('address/{id}', 'App\Http\Controllers\AddressController@getMethodShow');
    Route::put('address/{id}', 'App\Http\Controllers\AddressController@getMethodUpdate');
    Route::delete('address/{id}', 'App\Http\Controllers\AddressController@getMethodDestroy');
});
