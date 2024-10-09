<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\PdfController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// AUTH
Route::post('/login', [AuthController::class, 'login']);

// Route de logout - protégée par middleware auth:sanctum
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Get user informations
Route::get('/user-info', fn(Request $request) => $request->user())->middleware('auth:sanctum');

// Auth
Route::middleware(['auth:sanctum'])->group(function(){

    // Route pour generer le fichier PDF a partir du Template
    Route::post('/generate-pdf-with-template', [PdfController::class, 'generate']);
});
