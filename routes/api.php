<?php

use App\Http\Controllers\Api\PersonajeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\IsUserAuth;
use App\Http\Controllers\GameController;
use App\Http\Controllers\Api\PersonajesController;



Route::get('/cards/category/{categoryId}', [CardController::class, 'getByCategory']);
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware([IsUserAuth::class])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'getUser']);
    Route::post('personajes', [PersonajesController::class, 'addPersonaje']);
});




Route::middleware(['auth:api'])->group(function () {
    Route::get('/games', [GameController::class, 'index']);
    Route::post('/games', [GameController::class, 'store']);
    Route::put('/games/{game}/finish', [GameController::class, 'update']);
    Route::delete('/games/{game}', [GameController::class, 'destroy']);
    Route::get('/ranking', [GameController::class, 'ranking']);
    Route::get('/games/user/{id}', [GameController::class, 'getGamesByUserId']);
});




Route::middleware([IsUserAuth::class])->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
});

//Route::get('/students', function () { return 'Student list'; });

// Route::post('/students', function () { return 'Creating student'; });

// Route::put('/students/{id}', function () { return 'Updating student'; });

// Route::delete('/students/{id}', function () { return 'Deleting student'; });

// Route::get('/students/{id}', function () {return 'Getting one student'; });



Route::get('/students', [StudentController::class, 'index']);
Route::post('/students', [StudentController::class, 'store']);
Route::get('/students/{id}', [StudentController::class, 'show']);
Route::put('/students/{id}', [StudentController::class, 'update']);
Route::patch('/students/{id}', [StudentController::class, 'updatePartial']);
Route::delete('/students/{id}', [StudentController::class, 'destroy']);
