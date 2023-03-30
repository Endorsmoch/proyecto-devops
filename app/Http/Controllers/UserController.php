<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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
        return User::all();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json($user);
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (User::where("id",$id)->exists()) {
            $user = User::find($id);
            $user->fill($request->only([
                'userName',
                'email',
                'password',
            ]));
            $user->save();
            return response()->json([
                "message" => "User updated successfully",
                'user' => $user
            ], 200);
        } else {
            return response()->json([
                "error" => "User not found",
            ], 404);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (User::where('id', $id)->exists()) {
            $user = User::find($id);
            $user ->delete();
            return response()->json([
                "message" => "User deleted successfully",
            ], 202);
        } else {
            return response()->json([
                "error" => "User not found",
            ], 404);
        }
    }

    public function getMethodIndex() 
    {
        return $this->index();
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