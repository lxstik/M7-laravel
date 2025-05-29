<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Contracts\Providers\JWT;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request){
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
            'email' => $request->get('email'),
            'role' => $request->get('role'),
            'password' => bcrypt($request->get('password')),
        ]);

        return response()->json([
            'mensaje' => 'Usuario resgistrado',
            'user' => $user
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
                    'error' => 'No estas autorizado'
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'No se ha podido crear el token',
                'mensaje' => $e->getMessage(),
            ], 500);
        }
        return response()->json([
            'token' => $token,
            'user' => Auth::user(),
        ], 200);

    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'mensaje' => 'Sesion cerrada',
        ], 200);
    }

    public function usuarios(){

        $usuarios = User::all();

        return response()->json([
            'mensaje' => 'Mascotas',
            'usuarios' => $usuarios
        ], 200);
    }

    public function usuarioInfo($id){

        $usuario = User::find($id);

        return response()->json([
            'mensaje' => 'Usuario encontrado',
            'usuario' => $usuario
        ], 200);
    }

    public function usuarioEditar(Request $request, $id){

        $usuario = User::find($id);

         $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:100|in:admin,user',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);


        if($validator->fails()){
             return response()->json($validator->errors(), 422);
        }

        if(!$usuario){
            return response()->json(['mensaje' => 'user no encontrado'], 404);
        }

        $usuario->update($request->all());
        return response()->json(['usuario' => $usuario], 200);

    }

    public function usuarioBorrar($id){

        $usuario = User::find($id);

        if(!$usuario){
            return response()->json(['mensaje' => 'user no encontrado'], 404);
        }

        $usuario->delete();
        return response()->json(['mensaje' => 'user borrado'], 200);

    }

}
