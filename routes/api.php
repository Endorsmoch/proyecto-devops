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
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
    Route::post('register', 'App\Http\Controllers\AuthController@register');
    Route::delete('deleteUser', 'App\Http\Controllers\AuthController@deleteUser');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'store'
], function ($router) {
    Route::get('products', 'App\Http\Controllers\ProductController@index');
    Route::post('products', 'App\Http\Controllers\ProductController@store');
    Route::get('products/{id}', 'App\Http\Controllers\ProductController@show');
    Route::put('products/{id}', 'App\Http\Controllers\ProductController@update');
    Route::delete('products/{id}', 'App\Http\Controllers\ProductController@destroy');
});
