<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\Admin\WisatawanApiController;
use App\Http\Controllers\Api\Admin\WisataApiController;
use App\Http\Controllers\Api\Ptw\managePropertiesController;
use App\Http\Controllers\Api\Ptw\manageTicketsController;
use App\Http\Controllers\Api\Ptw\profilPTWController;

//Admin
use App\Http\Controllers\Api\admin\WisatawanApiController;
use App\Http\Controllers\Api\admin\WisataApiController;
use App\Http\Controllers\Api\admin\ProfileApiController;

/*
|--------------------------------------------------------------------------
| AUTHENTICATION (Untuk Semua Role)
|--------------------------------------------------------------------------
*/
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthApiController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| ROLE: ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [WisatawanApiController::class, 'index']);
    Route::post('/users', [WisatawanApiController::class, 'store']);
    Route::patch('/users/{id}/status', [WisatawanApiController::class, 'updateStatus']);
    Route::delete('/users/{id}', [WisatawanApiController::class, 'destroy']);

    Route::get('/wisata', [WisataApiController::class, 'index']);
    Route::post('/wisata', [WisataApiController::class, 'store']);
    Route::patch('/wisata/{id}/approve', [WisataApiController::class, 'approve']);
    Route::delete('/wisata/{id}', [WisataApiController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| ROLE: PTW (Pemilik Tempat Wisata)
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
| ROLE: WISATAWAN
|--------------------------------------------------------------------------
*/
Route::prefix('user')->group(function () {
    $namespace = 'App\Http\Controllers\Wisatawan';

    // Public Routes (Tanpa Token)
    Route::get('/home', [$namespace . '\HomeController', 'index']);
    Route::get('/destinasi', [$namespace . '\DestinasiController', 'index']);
    Route::get('/pencarian', [$namespace . '\PencarianController', 'index']);

    // Private Routes (Butuh Token)
    Route::middleware('auth:sanctum')->group(function () use ($namespace) {
        Route::get('/profil', [$namespace . '\ProfilController', 'index']);
        Route::post('/profil/update', [$namespace . '\editProfilController', 'update']);
        Route::get('/bookmark', [$namespace . '\BookmarkController', 'index']);
        Route::post('/bookmark', [$namespace . '\BookmarkController', 'store']);
        Route::post('/pesan-tiket', [$namespace . '\PesanTiketController', 'store']);
        Route::post('/penilaian', [$namespace . '\PenilaianController', 'store']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
});
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
<<<<<<< HEAD

// --- ROUTE UNTUK PROFILE USER ---
Route::get('profile', [ProfileApiController::class, 'index']);      
Route::post('profile', [ProfileApiController::class, 'store']);    
Route::put('profile/{id}', [ProfileApiController::class, 'update']); 
Route::delete('profile/{id}', [ProfileApiController::class, 'destroy']);
=======
Route::put('wisata/{id}', [WisataApiController::class, 'update']);
// Pastikan ada baris ini beb:
Route::put('wisata/{id}', [WisataApiController::class, 'update']); // <--- INI WAJIB ADA
>>>>>>> c19b52e6393778b6a492ef66276fe2f624aa6c83
>>>>>>> 3b784bbbcde820ce35e1c125862e6663ce119610
