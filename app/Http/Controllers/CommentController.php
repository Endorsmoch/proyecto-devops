<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
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
        
        $validator = Validator::make($request->all(), [
            'idProduct' => 'required',
            'idUser' => 'required',
            'text' => 'required',
            'likes' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $comment = Comment::create($validator->validate());
        return response()->json([
            'message' => 'Comment successfully created',
            'comment' => $comment
        ],201);
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
        if (Comment::where("id",$id)->exists()) {
            $comment = Comment::find($id);
            $comment->fill($request->only([
                'idProduct',
                'idUser',
                'text',
                'likes'
            ]));
            $comment->save();
            return response()->json([
                "message" => "Comment updated successfully",
                'comment' => $comment
            ], 200);
        } else {
            return response()->json([
                "error" => "Comment not found",
            ], 404);
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
