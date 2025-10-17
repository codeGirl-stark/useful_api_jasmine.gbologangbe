<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ModuleActivationController;
use App\Http\Controllers\ShortLinkController;

// Route d'inscription
Route::post('/register', [AuthController::class, 'register']);

// Route de connexion
Route::post('/login', [AuthController::class, 'login']);

Route::get('/s/{code}', [ShortLinkController::class, 'redirect']);

// Routes protégées par Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/modules', [ModuleController::class, 'index']);
    Route::post('/modules/{id}/activate', [ModuleActivationController::class, 'activate']);
    Route::post('/modules/{id}/deactivate', [ModuleActivationController::class, 'deactivate']);
    // POST /shorten
    Route::post('/shorten', [ShortLinkController::class, 'shorten']);
    // GET /links
    Route::get('/links', [ShortLinkController::class, 'index']);
    // DELETE /links/{id}
    Route::delete('/links/{id}', [ShortLinkController::class, 'destroy']);
});
