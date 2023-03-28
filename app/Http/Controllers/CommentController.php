<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Comment::all(); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return Comment::create($request->all(),[
            'idProducto' => 'required',
            'user_id' => 'required',
            'texto' => 'required',
            'likes'=> 'required'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Comment::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Comment::where('id', $id)->exists()){
            $comment = Comment::find($id);
            $comment->idProducto = $request->idProducto;
            $comment->user_id = $request->user_id;
            $comment->texto = $request->texto;
            $comment->likes = $request->likes;

            $comment->save();
            return response()->json([
                "message" => "record updated successfully"

            ], 200);
        }else{
            return response()->json([
                "message" => "Comment not found"
            ],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Comment::where('id', $id)->exists()){
            $comment = Comment::find($id);
            $comment->delete();

            return response()->json([
                "message" => "Record deleted"
            ], 202);
        }else{
            return response()->json([
                "message" => "Comment not found"
            ], 404);
        }
    }
}
