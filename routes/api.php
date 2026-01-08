<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\Ptw\managePropertiesController;

<<<<<<< HEAD
use App\Http\Controllers\Api\WisatawanApiController;
use App\Http\Controllers\Api\WisataApiController;


// Rute untuk Flutter (Tanpa Middleware Auth dahulu agar mudah dites dengan Postman)
Route::prefix('flutter')->group(function () {
=======
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);
>>>>>>> ea15caa7f9257bbc5f984cf2a39339e8e908fbcd

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/properties', [managePropertiesController::class, 'index']);
    Route::post('/properties', [managePropertiesController::class, 'store']);
    Route::get('/properties/{id}', [managePropertiesController::class, 'show']);
    Route::put('/properties/{id}', [managePropertiesController::class, 'update']);
    Route::delete('/properties/{id}', [managePropertiesController::class, 'destroy']);
    Route::get('/properties/{id_wisata}/tickets', [manageTicketsController::class, 'index']);
    Route::post('/properties/{id_wisata}/tickets', [manageTicketsController::class, 'store']);
    Route::get('/tickets/{id_tiket}', [manageTicketsController::class, 'show']);
    Route::put('/tickets/{id_tiket}', [manageTicketsController::class, 'update']);
    Route::delete('/tickets/{id_tiket}', [manageTicketsController::class, 'destroy']);
    Route::get('/profile', [profilPTWController::class, 'show']);
    Route::put('/profile/update', [profilPTWController::class, 'update']);
});

// admin




// --- CRUD USER (Tabel: wisatawan) ---
Route::get('/users', [WisatawanApiController::class, 'index']);
Route::post('/users', [WisatawanApiController::class, 'store']);
Route::patch('/users/{id}/status', [WisatawanApiController::class, 'updateStatus']);
Route::delete('/users/{id}', [WisatawanApiController::class, 'destroy']);

// --- CRUD WISATA (Tabel: tempat_wisatas) ---
Route::get('/wisata', [WisataApiController::class, 'index']);
Route::post('/wisata', [WisataApiController::class, 'store']);
Route::patch('/wisata/{id}/approve', [WisataApiController::class, 'approve']);
Route::delete('/wisata/{id}', [WisataApiController::class, 'destroy']);