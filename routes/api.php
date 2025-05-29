<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsUserAdmin;
use App\Http\Middleware\IsUserAuth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MascotaController;




Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);





Route::middleware([IsUserAuth::class])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('pets', [MascotaController::class, 'insertarMisMascotas']);
    Route::put('pets/{id}', [MascotaController::class, 'editarMisMascotas']);
    Route::get('pets', [MascotaController::class, 'misMascotas']);
    Route::delete('pets/{id}', [MascotaController::class, 'eliminarMisMascotas']);
    Route::get('pets/{id}', [MascotaController::class, 'mostrarMascota']);
    Route::patch('pets/{id}', [MascotaController::class, 'cambiaMisMascotas']);
});

Route::middleware([IsUserAdmin::class])->group(function () {
    Route::get('users/', [AuthController::class, 'usuarios']);
    Route::get('users/{id}/pets', [MascotaController::class, 'mascotasOtros']);
    Route::get('users/{id}', [AuthController::class, 'usuarioConcreto']);
    Route::delete('users/{id}', [AuthController::class, 'usuarioConcretoBorrar']);
    Route::put('users/{id}', [AuthController::class, 'usuarioConcretoEditar']);
});
