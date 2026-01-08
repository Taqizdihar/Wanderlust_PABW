<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\Ptw\managePropertiesController;
use App\Http\Controllers\Api\Ptw\manageTicketsController;
use App\Http\Controllers\Api\Ptw\profilPTWController;
use App\Http\Controllers\Api\Admin\WisatawanApiController;
use App\Http\Controllers\Api\Admin\WisataApiController;

use App\Http\Controllers\Api\admin\WisatawanApiController;
use App\Http\Controllers\Api\admin\WisataApiController;

// --- BAGIAN FLUTTER (TIDAK DIUBAH) ---
Route::prefix('flutter')->group(function () {
    Route::post('/login', [ApiFlutterController::class, 'login']);
    Route::get('/stats/{id}', [ApiFlutterController::class, 'getStats']);
    Route::get('/properties/{id}', [ApiFlutterController::class, 'getProperties']);
    Route::get('/profile/{id}', [ApiFlutterController::class, 'getProfile']);
    Route::get('/wisatawan/destinasi', [ApiFlutterController::class, 'getDestinasiWisatawan']);
    Route::get('/wisatawan/search', [ApiFlutterController::class, 'search']);
    Route::get('/wisatawan/bookmarks/{id}', [ApiFlutterController::class, 'getBookmarks']);
    Route::get('/wisatawan/tickets/{id}', [ApiFlutterController::class, 'getUserTickets']); 
    Route::post('/wisatawan/bookmarks/toggle', [ApiFlutterController::class, 'toggleBookmark']);
    Route::post('/wisatawan/pesan-tiket', [ApiFlutterController::class, 'pesanTiket']);
    Route::get('/admin/members', [ApiFlutterController::class, 'getAdminMembers']);
    Route::get('/admin/owners', [ApiFlutterController::class, 'getAdminOwners']);
    Route::get('/admin/properties', [ApiFlutterController::class, 'getAdminProperties']);
});

// --- ADMIN (TIDAK DIUBAH) ---
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