<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

Route::middleware([IsUserAuth::class])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'getUser']);
    Route::gost('personajes', [PersonajesController::class, 'addPersonaje'])
});


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'role' => 'required|string|in:admin,user',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:5|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'role' => $request->get('role'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'Invalid credentials'
                ], 401);
            }
            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
            ], 200);

        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not create token',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUser(){
        $user = Auth::user();
        return response()->json([
            'message' => 'User retrieved successfully',
            'data' => $user,
        ],200);
    }

    public function logout(){
        try{
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'message' => 'User logged out successfully',
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not log out',
            ], 500);
        }
    }
}
