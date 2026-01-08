<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\Ptw\managePropertiesController;
use App\Http\Controllers\Api\Ptw\manageTicketsController;
use App\Http\Controllers\Api\Ptw\profilPTWController;
use App\Http\Controllers\Api\Admin\WisatawanApiController;
use App\Http\Controllers\Api\Admin\WisataApiController;

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

Route::get('/users', [WisatawanApiController::class, 'index']);
Route::post('/users', [WisatawanApiController::class, 'store']);
Route::patch('/users/{id}/status', [WisatawanApiController::class, 'updateStatus']);
Route::delete('/users/{id}', [WisatawanApiController::class, 'destroy']);

Route::get('/wisata', [WisataApiController::class, 'index']);
Route::post('/wisata', [WisataApiController::class, 'store']);
Route::patch('/wisata/{id}/approve', [WisataApiController::class, 'approve']);
Route::delete('/wisata/{id}', [WisataApiController::class, 'destroy']);

Route::prefix('user')->group(function () {
    $namespace = 'App\Http\Controllers\Wisatawan';

    // Endpoint Home
    Route::get('/home', [$namespace . '\HomeController', 'index']);
    
    // Endpoint Destinasi & Pencarian
    Route::get('/destinasi', [$namespace . '\DestinasiController', 'index']);
    Route::get('/pencarian', [$namespace . '\PencarianController', 'index']);
    
    // Endpoint Profil & Edit Profil
    Route::get('/profil', [$namespace . '\ProfilController', 'index']);
    Route::post('/profil/update', [$namespace . '\editProfilController', 'update']);
    
    // Endpoint Bookmark
    Route::get('/bookmark', [$namespace . '\BookmarkController', 'index']);
    Route::post('/bookmark', [$namespace . '\BookmarkController', 'store']);
    
    // Endpoint Pesan Tiket
    Route::post('/pesan-tiket', [$namespace . '\PesanTiketController', 'store']);
    
    // Endpoint Penilaian
    Route::post('/penilaian', [$namespace . '\PenilaianController', 'store']);
});