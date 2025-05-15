<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

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
