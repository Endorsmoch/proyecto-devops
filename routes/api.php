<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Comment;
use App\Http\Controllers\CommentController;
use App\Http\Resources\CommentResource;

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

Route::get('/comment/{idComentario}', function ($id) {
    return new CommentResource(Comment::findOrFail($id));
});

Route::get('/comments', function () {
    return CommentResource::collection(Comment::all());
});

Route::put('/comment/{idComentario}', [CommentController::class, 'update']);

Route::delete('/comment/{idComentario}', [CommentController::class, 'destroy']);

Route::post('/comments', [CommentController::class, 'store']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
