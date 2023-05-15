<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;

use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getMethodLogin', 'getMethodRegister', 'checkToken']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $requestContent = json_decode($request->getContent(), true);
            Log::debug('User log in request body: ' . $this->obfuscateSensitiveData($requestContent));
            $credentials = request(['email', 'password']);
            if (!$token = auth()->attempt($credentials)) {
                Log::warning("Error while executing login operation: Unauthorized Log In.");
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            $user = auth()->user();
            $user->lastLoginDate = now();
            $user->save();
            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            Log::error("Error while loggin in: {$e->getMessage()}", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error while logging in'], 500);
        }
    }

    public function checkToken(Request $request)
    {
        try {
            $token = JWTAuth::parseToken()->getToken();
            $user = JWTAuth::authenticate($token);
            if (!$user) {
                return response()->json(['valid' => false], 401);
            }
            return response()->json(['valid' => true], 200);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['valid' => false], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['valid' => false], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['valid' => false], 500);
        }
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        try {
            $requestContent = json_decode($request->getContent(), true);
            Log::debug('Me method request body: ' . $this->obfuscateSensitiveData($requestContent));
            $user = auth()->userOrFail();
            return response()->json($user);
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            Log::error("Error while fetching current user: {$e->getMessage()}", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'User not found'], 404);
        } catch (\Exception $e) {
            Log::error("Error while fetching current user: {$e->getMessage()}", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $requestContent = json_decode($request->getContent(), true);
        Log::debug('User Logout request body: ' . $this->obfuscateSensitiveData($requestContent));
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        try {
            $requestContent = json_decode($request->getContent(), true);
            Log::debug('Refresh method request body: ' . $this->obfuscateSensitiveData($requestContent));
            return $this->respondWithToken(auth()->refresh());
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            Log::warning('Invalid token while refreshing token');
            return response()->json(['error' => 'Token invalid'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            Log::warning('Expired token while refreshing token');
            return response()->json(['error' => 'Token expired'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            Log::warning('Absent token while refreshing token');
            return response()->json(['error' => 'Token absent'], 401);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request)
    {
        try {
            $requestContent = json_decode($request->getContent(), true);
            Log::debug('Register user request body: ' . $this->obfuscateSensitiveData($requestContent));
            $validator = Validator::make($request->all(), [
                'userName' => 'required',
                'email' => 'required|string|email|max:100|unique:users',
                'password' => 'required|string|min:6'
            ]);
            if ($validator->fails()) {
                Log::warning("Validation failed while register user operation: " . implode('|', $validator->errors()->all()));
                return response()->json($validator->errors()->toJson(), 400);
            }
            $user = User::create(array_merge(
                $validator->validate(),
                [
                    'password' => bcrypt($request->password),
                    //'createdDate' => now()
                ]
            ));
            return response()->json([
                'message' => 'Successfully created',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            Log::error("Error while registering user: {$e->getMessage()}", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error while registering user'], 500);
        }
    }

    private function obfuscateSensitiveData($data)
    {
        if ($data === null) {
            return null;
        }
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->obfuscateSensitiveData($value);
            } elseif ($this->isSensitiveData($key)) {
                $data[$key] = '***'; // Ofuscar información sensible
            }
        }
        return json_encode($data);
    }

    private function isSensitiveData(string $key)
    {
        return in_array($key, ['email', 'password']);
    }

    public function getMethodLogin(Request $request)
    {
        return $this->login($request);
    }

    public function getMethodMe(Request $request)
    {
        return $this->me($request);
    }

    public function getMethodRegister(Request $request)
    {
        return $this->register($request);
    }

    public function getMethodLogout(Request $request)
    {
        return $this->logout($request);
    }

    public function getMethodRefresh(Request $request)
    {
        return $this->refresh($request);
    }
}
