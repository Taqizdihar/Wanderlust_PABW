<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\Admin\WisatawanApiController;
use App\Http\Controllers\Api\Admin\WisataApiController;
use App\Http\Controllers\Api\Admin\ProfileApiController;
use App\Http\Controllers\Api\Ptw\managePropertiesController;
use App\Http\Controllers\Api\Ptw\manageTicketsController;
use App\Http\Controllers\Api\Ptw\profilPTWController;

/*
|--------------------------------------------------------------------------
| 1. AUTHENTICATION (Public & Private)
|--------------------------------------------------------------------------
*/
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
});

/*
|--------------------------------------------------------------------------
| 2. ROLE: ADMIN (Butuh Token)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    // Kelola Users
    Route::get('/users', [WisatawanApiController::class, 'index']);
    Route::post('/users', [WisatawanApiController::class, 'store']);
    Route::put('/users/{id}', [WisatawanApiController::class, 'update']);
    Route::patch('/users/{id}/status', [WisatawanApiController::class, 'updateStatus']);
    Route::delete('/users/{id}', [WisatawanApiController::class, 'destroy']);

    // Kelola Wisata
    Route::get('/wisata', [WisataApiController::class, 'index']);
    Route::post('/wisata', [WisataApiController::class, 'store']);
    Route::put('/wisata/{id}', [WisataApiController::class, 'update']);
    Route::patch('/wisata/{id}/approve', [WisataApiController::class, 'approve']);
    Route::delete('/wisata/{id}', [WisataApiController::class, 'destroy']);

    // Profile Admin
    Route::get('/profile', [ProfileApiController::class, 'index']);
    Route::put('/profile/{id}', [ProfileApiController::class, 'update']);
});

/*
|--------------------------------------------------------------------------
| 3. ROLE: PTW (Pemilik Tempat Wisata - Butuh Token)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->prefix('ptw')->group(function () {
    Route::get('/properties', [managePropertiesController::class, 'index']);
    Route::post('/properties', [managePropertiesController::class, 'store']);
    Route::get('/properties/{id}', [managePropertiesController::class, 'show']);
    Route::put('/properties/{id}', [managePropertiesController::class, 'update']);
    Route::delete('/properties/{id}', [managePropertiesController::class, 'destroy']);
    
    Route::get('/properties/{id_wisata}/tickets', [manageTicketsController::class, 'index']);
    Route::post('/properties/{id_wisata}/tickets', [manageTicketsController::class, 'store']);
    
    Route::get('/profil', [profilPTWController::class, 'index']);
});

/*
|--------------------------------------------------------------------------
| 4. ROLE: WISATAWAN
|--------------------------------------------------------------------------
*/
Route::prefix('user')->group(function () {
    $ns = 'App\Http\Controllers\Wisatawan';

    // Public (Tanpa Login)
    Route::get('/home', [$ns . '\HomeController', 'index']);
    Route::get('/destinasi', [$ns . '\DestinasiController', 'index']);
    Route::get('/pencarian', [$ns . '\PencarianController', 'index']);

    // Private (Harus Login)
    Route::middleware('auth:sanctum')->group(function () use ($ns) {
        Route::get('/profil', [$ns . '\ProfilController', 'index']);
        Route::post('/profil/update', [$ns . '\editProfilController', 'update']);
        Route::get('/bookmark', [$ns . '\BookmarkController', 'index']);
        Route::post('/bookmark', [$ns . '\BookmarkController', 'store']);
        Route::post('/pesan-tiket', [$ns . '\PesanTiketController', 'store']);
        Route::post('/penilaian', [$ns . '\PenilaianController', 'store']);
    });
});