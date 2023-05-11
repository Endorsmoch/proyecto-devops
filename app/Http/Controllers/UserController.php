<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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
        try {
            return User::all();
        } catch (\Exception $e){
            Log::error("Error while getting all users: $e->getMessage()", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error while getting all users'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $method_name = 'show()';
        try {
            $user = User::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            $this->logUserNotFound($method_name);
            return response()->json(['error' => 'User not found'], 404);
        } catch (\Exception $e) {
            Log::error("Error while looking for the user with ID {$id}: {$e->getMessage()}", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'An error occurred while looking for the user'], 500);
        }
        
        return response()->json($user);
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $method_name = 'update()';
        try {
            Log::debug('Update user request body: '. $this->obfuscateSensitiveData($request->getContent()));
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
                $this->logUserNotFound($method_name);
                return response()->json([
                    "error" => "User not found",
                ], 404);
            }
        } catch (\Exception $e) {
            Log::error("Error while updating user with ID $id: $e->getMessage()", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error while updating user'], 500);
        }
        
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $method_name = 'destroy()';
        try{
            if (User::where('id', $id)->exists()) {
                $user = User::find($id);
                $user ->delete();
                return response()->json([
                    "message" => "User deleted successfully",
                ], 202);
            } else {
                $this->logUserNotFound($method_name);
                return response()->json([
                    "error" => "User not found",
                ], 404);
            }
        } catch (\Exception $e) {
            Log::error("Error while deleting user with ID $id: $e->getMessage()", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error while deleting user'], 500);
        }
        
    }

    private function obfuscateSensitiveData(array $data) 
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->obfuscateSensitiveData($value);
            } elseif ($this->isSensitiveData($key)) {
                $data[$key] = '***'; // Ofuscar información sensible
            }
        }
    
        return $data;
    }

    private function isSensitiveData(string $key)
    {
        return in_array($key, ['email', 'password']);
    }

    private function logUserNotFound(String $method) {
        Log::warning("User not Found while calling $method method in UserController.");
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