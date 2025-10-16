<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ModuleActivationController;

// Route d'inscription
Route::post('/register', [AuthController::class, 'register']);

// Route de connexion
Route::post('/login', [AuthController::class, 'login']);

// Routes protégées par Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/modules', [ModuleController::class, 'index']);
    Route::post('/modules/{id}/activate', [ModuleActivationController::class, 'activate']);
    Route::post('/modules/{id}/deactivate', [ModuleActivationController::class, 'deactivate']);
});
