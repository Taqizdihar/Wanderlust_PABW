<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\Ptw\managePropertiesController;
use App\Http\Controllers\Api\Ptw\manageTicketsController;
use App\Http\Controllers\Api\Ptw\profilPTWController;

// JANGAN GANNGU!!!!!!
//Admin
use App\Http\Controllers\Api\admin\WisatawanApiController;
use App\Http\Controllers\Api\admin\WisataApiController;
use App\Http\Controllers\Api\admin\ProfileApiController;


Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->prefix('ptw')->group(function () {
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

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
});

// JANGAN GANGGU!!!!!
//admin
// --- ROUTE UNTUK WISATAWAN ---


// --- ROUTE UNTUK WISATAWAN ---


Route::get('users', [WisatawanApiController::class, 'index']);
Route::post('users', [WisatawanApiController::class, 'store']);
Route::put('users/{id}', [WisatawanApiController::class, 'update']); 
Route::patch('users/{id}/status', [WisatawanApiController::class, 'updateStatus']);
Route::delete('users/{id}', [WisatawanApiController::class, 'destroy']);
// --- ROUTE UNTUK TEMPAT WISATA ---
Route::get('wisata', [WisataApiController::class, 'index']);
Route::post('wisata', [WisataApiController::class, 'store']);
Route::put('wisata/{id}', [WisataApiController::class, 'update']); 
Route::patch('wisata/{id}/approve', [WisataApiController::class, 'approve']);
Route::delete('wisata/{id}', [WisataApiController::class, 'destroy']);

// --- ROUTE UNTUK PROFILE (Tabel Users) ---
Route::get('profile', [ProfileApiController::class, 'index']);      
Route::post('profile', [ProfileApiController::class, 'store']);    
Route::put('profile/{id}', [ProfileApiController::class, 'update']); 
Route::delete('profile/{id}', [ProfileApiController::class, 'destroy']);
Route::patch('wisata/{id}/status', [WisataApiController::class, 'updateStatus']);

// JANGAN GANNGU!!!!!!


