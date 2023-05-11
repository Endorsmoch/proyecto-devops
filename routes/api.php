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
    Route::post('login', 'App\Http\Controllers\AuthController@getMethodLogin')->name('auth.login');
    Route::post('logout', 'App\Http\Controllers\AuthController@getMethodLogout')->name('auth.logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@getMethodRefresh')->name('auth.refresh');
    Route::get('me', 'App\Http\Controllers\AuthController@getMethodMe')->name('auth.me');
    Route::post('register', 'App\Http\Controllers\AuthController@getMethodRegister')->name('auth.register');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'account'
], function ($router) {
    Route::get('users', 'App\Http\Controllers\UserController@getMethodIndex')->name('account.users');
    Route::get('users/{id}', 'App\Http\Controllers\UserController@getMethodShow')->name('account.users{id}');
    Route::put('users/{id}', 'App\Http\Controllers\UserController@getMethodUpdate')->name('account.users{id}');
    Route::delete('users/{id}', 'App\Http\Controllers\UserController@getMethodDestroy')->name('account.users{id}');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'store'
], function ($router) {
    //Comment paths
    Route::get('comments', 'App\Http\Controllers\CommentController@getMethodIndex')->name('store.comments');
    Route::post('comments','App\Http\Controllers\CommentController@getMethodStore')->name('store.comments');
    Route::get('comment/{id}', 'App\Http\Controllers\CommentController@getMethodShow')->name('store.comment{id}');
    Route::put('comment/{id}', 'App\Http\Controllers\CommentController@getMethodUpdate')->name('store.comment{id}');
    Route::delete('comment/{id}', 'App\Http\Controllers\CommentController@getMethodDestroy')->name('store.comment{id}');

    //Product paths
    Route::get('products', 'App\Http\Controllers\ProductController@getMethodIndex')->name('store.products');
    Route::post('products', 'App\Http\Controllers\ProductController@getMethodStore')->name('store.products');
    Route::get('products/{id}', 'App\Http\Controllers\ProductController@getMethodShow')->name('store.products{id}');
    Route::put('products/{id}', 'App\Http\Controllers\ProductController@getMethodUpdate')->name('store.products{id}');
    Route::delete('products/{id}', 'App\Http\Controllers\ProductController@getMethodDestroy')->name('store.products{id}');

    //Order paths
    Route::get('orders', 'App\Http\Controllers\OrderController@getMethodIndex')->name('store.orders');
    Route::post('orders','App\Http\Controllers\OrderController@getMethodStore')->name('store.orders');
    Route::get('order/{id}', 'App\Http\Controllers\OrderController@getMethodShow')->name('store.order{id}');
    Route::put('order/{id}', 'App\Http\Controllers\OrderController@getMethodUpdate')->name('store.order{id}');
    Route::delete('order/{id}', 'App\Http\Controllers\OrderController@getMethodDestroy')->name('store.order{id}');

    //Address paths
    Route::get('addresses', 'App\Http\Controllers\AddressController@getMethodIndex')->name('store.addresses');
    Route::post('addresses','App\Http\Controllers\AddressController@getMethodStore')->name('store.addresses');
    Route::get('address/{id}', 'App\Http\Controllers\AddressController@getMethodShow')->name('store.address{id}');
    Route::put('address/{id}', 'App\Http\Controllers\AddressController@getMethodUpdate')->name('store.address{id}');
    Route::delete('address/{id}', 'App\Http\Controllers\AddressController@getMethodDestroy')->name('store.address{id}');
});
