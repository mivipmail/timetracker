<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/auth-user', [\App\Http\Controllers\AuthController::class, 'authUser']);

Route::group(['prefix' => 'projects', 'middleware' => 'auth:sanctum'], function() {
    Route::get('/', [\App\Http\Controllers\ProjectController::class, 'index']);
    Route::post('/', [\App\Http\Controllers\ProjectController::class, 'store']);
    Route::get('/{id}', [\App\Http\Controllers\ProjectController::class, 'show']);
    Route::patch('/{id}', [\App\Http\Controllers\ProjectController::class, 'update']);
    Route::delete('/{id}', [\App\Http\Controllers\ProjectController::class, 'destroy']);
});

Route::group(['prefix' => 'tasks', 'middleware' => 'auth:sanctum'], function() {
    Route::get('/{project_id}', [\App\Http\Controllers\TaskController::class, 'index']);
    Route::post('/', [\App\Http\Controllers\TaskController::class, 'store']);
    Route::get('/{id}', [\App\Http\Controllers\TaskController::class, 'show']);
    Route::patch('/{id}', [\App\Http\Controllers\TaskController::class, 'update']);
    Route::delete('/{id}', [\App\Http\Controllers\TaskController::class, 'destroy']);
    
    Route::patch('/start/{id}', [\App\Http\Controllers\TaskController::class, 'start']);
    Route::patch('/stop/{id}', [\App\Http\Controllers\TaskController::class, 'stop']);
});
