<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Contracts\Providers\JWT;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:100|in:admin,user',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
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
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $credenciales = $request->only(['email', 'password']);

        try {
            if (!$token = JWTAuth::attempt($credenciales)) {
                return response()->json([
                    'error' => 'Unauthorized'
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not create token',
                'mesage' => $e->getMessage(),
            ], 500);
        }
        return response()->json([
            'token' => $token,
            'user' => Auth::user(),
        ], 200);

    }

    public function getUser()
    {
        $user = Auth::user();
        return response()->json([
            'user' => $user,
        ], 200);

    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'User logged out successfully',
        ], 200);
    }

}
