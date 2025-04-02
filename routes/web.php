<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('peliculas');
});


Route::get('/suma', function () {
    return view('suma');
});

Route::post('/suma', function (Request $request) {
    $num1 = $request->input('num1');
    $num2 = $request->input('num2');
    $resultado = $num1 + $num2;

    return view('suma', ['resultado' => $resultado]);
});
