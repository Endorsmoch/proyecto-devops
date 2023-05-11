<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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
        try {
            return Comment::all();
        } catch (\Exception $e) {
            Log::error("Error while getting all comments: $e->getMessage()", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error while getting all comments'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $requestContent = json_decode($request->getContent(), true);
            Log::debug('Store comment request body: '. $this->obfuscateSensitiveData($requestContent));
            $validator = Validator::make($request->all(), [
                'idProduct' => 'required',
                'idUser' => 'required',
                'text' => 'required',
                'likes' => 'required'
            ]);
            if ($validator->fails()) {
                Log::warning("Validation failed while store comment operation: ".implode('|',$validator->errors()->all()));
                return response()->json($validator->errors()->toJson(), 400);
            }
            $comment = Comment::create($validator->validate());
            return response()->json([
                'message' => 'Comment successfully created',
                'comment' => $comment
            ],201);
        } catch (\Exception $e) {
            Log::error("Error while storing comment: {$e->getMessage()}", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error while storing comment'], 500);
        }
        
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $method_name = 'show()';
        try {
            $comment = Comment::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e ) {
            $this->logCommentNotFound($method_name);
            return response()->json(['error' => 'Comment not found'], 404);
        } catch (\Exception $e) {
            Log::error("Error while looking for the comment with ID {$id}: {$e->getMessage()}", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'An error occurred while looking for the comment'], 500);
        }

        return response()->json($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $method_name = 'update()';
        try {
            Log::debug('Update comment request body: '. $reques->getContent());
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
                $this->logCommentNotFound($method_name);
                return response()->json([
                    "error" => "Comment not found",
                ], 404);
            }
        } catch (\Exception $th) {
            Log::error("Error while updating comment with ID $id: $e->getMessage()", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error while updating comment'], 500);
        }
        
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $method_name = 'destroy()';
        try {
            if(Comment::where('id', $id)->exists()){
                $comment = Comment::find($id);
                $comment->delete();
    
                return response()->json([
                    "message" => "Record deleted"
                ], 202);
            }else{
                $this->logCommentNotFound($method_name);
                return response()->json([
                    "message" => "Comment not found"
                ], 404);
            }
        } catch (\Exception $e) {
            Log::error("Error while deleting comment with ID $id: $e->getMessage()", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error while deleting comment'], 500);
        }
        
    }

    private function logCommentNotFound(String $method) {
        Log::warning("Comment not Found while calling $method method in CommentController.");
    }

    public function getMethodIndex() 
    {
        return $this->index();
    }

    public function getMethodStore(Request $request){
        return  $this->store($request);
    }

    public function getMethodShow(string $id)
    {
        return $this->show($id);
    }

    public function getMethodUpdate(Request $request, string $id) 
    {
        return $this->update($request, $id);
    }

    public function getMethodDestroy(string $id) 
    {
        return $this->destroy($id);
    }
}
