<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\FormController;
use App\Http\Controllers\Api\PdfController;
use App\Http\Controllers\Api\UserRequestFormController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// AUTH
Route::post('/login', [AuthController::class, 'login']);

// Route de logout - protégée par middleware auth:sanctum
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Get user informations
Route::get('/user-info', fn(Request $request) => $request->user())->middleware('auth:sanctum');

// Post form user
Route::post('/user-requests', [UserRequestFormController::class, 'store']);

// Auth
Route::middleware(['auth:sanctum'])->group(function(){

    Route::apiResource('user-requests', UserRequestFormController::class)->except('store','destroy');

    Route::apiResource('form', FormController::class);

    // Route pour generer le fichier PDF a partir du Template
    Route::post('/generate-pdf-with-template', [PdfController::class, 'generate']);
});
