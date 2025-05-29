<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class MascotaController extends Controller
{

    public function index()
    {
        return "HOla";
    }

    //para obtener las mascotas de un usuario autenticado
    public function misMascotas()
     {
        $userId = Auth::id();
        $mascotas = Mascota::where('user_id', $userId)->get();

        return response()->json([
            'message' => 'Mis mascotas',
            'data' => $mascotas
        ], 200);
    }

    //para insertar una mascota de un usuario autenticado
    public function insertarMisMascotas(Request $request)
    {
        $validator  = Validator::make($request->all(),[
            'nombre' => 'required|string|max:100',
            'imagen' => 'required|url',
            'tipo' => 'required|string|max:100',
        ]);
        if($validator->fails()){
             return response()->json($validator->errors(), 422);
        }
        $mascota = Mascota::create([
            'user_id' => Auth::id(),
            'nombre' => $request->nombre,
            'imagen' => $request->imagen,
            'tipo' => $request->tipo,
        ]);

        return response()->json([
            'mensaje' => 'Mascota registrada',
            'mascota' => $mascota
        ], 201);
    }

    //para editar una mascota de un usuario autenticado
    public function editarMisMascotas(Request $request, $id)
    {

        $mascota = Mascota::find($id);

        $userId = Auth::id();

        if($mascota->user_id != $userId ){
            return response()->json(['mensaje' => 'Esta mascota no te pertenece'], 404);
        }

          $validator  = Validator::make($request->all(),[
            'nombre' => 'required|string|max:100',
            'imagen' => 'required|url',
            'tipo' => 'required|string|max:100',
        ]);

        if($validator->fails()){
             return response()->json($validator->errors(), 422);
        }

        if(!$mascota){
            return response()->json(['mensaje' => 'No se encuentra a la mascota'], 404);
        }

        $mascota->update($request->all());
        return response()->json(['mascota' => $mascota], 200);

    }

    //para editar una mascota de un usuario autenticado
    public function cambiaMisMascotas(Request $request, $id)
    {
         $mascota = Mascota::find($id);

         $userId = Auth::id();

        if($mascota->user_id != $userId ){
            return response()->json(['mensaje' => 'Esta mascota no te pertenece'], 404);
        }

          $validator  = Validator::make($request->all(),[
            'nombre' => 'string|max:100',
            'imagen' => 'url',
            'tipo' => 'string|max:100',
        ]);

        if($validator->fails()){
             return response()->json($validator->errors(), 422);
        }

        if(!$mascota){
            return response()->json(['mensaje' => 'No se encuentra a la mascota'], 404);
        }

        $mascota->update($request->all());
        return response()->json(['mascota' => $mascota], 200);

    }

    public function eliminarMisMascotas(Request $request, $id)
    {
        $mascota = Mascota::find($id);
        if (!$mascota) {
            return response()->json(['mensaje' => 'No existe mascota con este id'], 404);
        }

        $mascota->delete();
        return response()->json(['mensaje' => 'Mascota eliminada'], 200);
    }

    public function mascotasOtros($id)
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            return response()->json(['error' => 'No eres el admin'], 403);
        }

        $mascotas = Mascota::where('user_id', $id)->get();

    return response()->json([
        'mensaje' => "Mascotas del usuario $id",
        'mascotas' => $mascotas
    ]);

    }


    public function mostrarMascota($id)
    {
        $mascota = Mascota::find($id);
        if (!$mascota) {
            return response()->json(['mensaje' => 'No existe mascota con este id'], 404);
        }

        $user = Auth::user();

        if ($user->role !== 'admin' && $mascota->user_id !== $user->id) {
            return response()->json(['mensaje' => 'No tienes permiso para ver esta mascota'], 403);
        }

        return response()->json(['mascota' => $mascota], 200);
    }

}
