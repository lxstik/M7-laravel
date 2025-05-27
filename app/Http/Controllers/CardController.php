<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{

    public function getByCategory($categoryId)
    {
        $cards = Card::where('category_id', $categoryId)->get();

        return response()->json($cards);
    }




    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:100',
        'url_imagen' => 'required|url',
        'category_id' => 'nullable|exists:categories,id',
    ]);

    $card = Card::create([
        'nombre' => $request->nombre,
        'url_imagen' => $request->url_imagen,
        'category_id' => $request->category_id,
        'user_id' => Auth::id(), // 🔑 afegim l'usuari que l'ha creat
    ]);

    return response()->json([
        'message' => 'Targeta creada',
        'data' => $card
    ], 201);
}






    public function all()
    {
        return Card::with('user', 'category')->get();
    }

    // Eliminar qualsevol targeta (com admin)
    public function adminDestroy(Card $card)
    {
        $card->delete();
        return response()->json(['message' => 'Targeta eliminada per admin']);
    }

    // Opcional: editar targeta com admin
    public function adminUpdate(Request $request, Card $card)
    {
        $request->validate([
            'nombre' => 'sometimes|string|max:100',
            'url_imagen' => 'sometimes|url',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $card->update($request->all());

        return response()->json([
            'message' => 'Targeta actualitzada per admin',
            'data' => $card
        ]);
    }
}
