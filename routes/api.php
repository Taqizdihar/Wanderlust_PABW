<?php

use App\Http\Controllers\Api\ApiFlutterController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\admin\WisatawanApiController;
use App\Http\Controllers\Api\admin\WisataApiController;


// Rute untuk Flutter (Tanpa Middleware Auth dahulu agar mudah dites dengan Postman)
Route::prefix('flutter')->group(function () {

    Route::post('/login', [ApiFlutterController::class, 'login']);
    
    Route::get('/stats/{id}', [ApiFlutterController::class, 'getStats']);
    Route::get('/properties/{id}', [ApiFlutterController::class, 'getProperties']);
    Route::get('/profile/{id}', [ApiFlutterController::class, 'getProfile']);
    
    Route::get('/wisatawan/destinasi', [ApiFlutterController::class, 'getDestinasiWisatawan']);
    Route::get('/wisatawan/search', [ApiFlutterController::class, 'search']);
    Route::get('/wisatawan/bookmarks/{id}', [ApiFlutterController::class, 'getBookmarks']);
    // PERBAIKAN: Pastikan nama method sesuai
    Route::get('/wisatawan/tickets/{id}', [ApiFlutterController::class, 'getUserTickets']); 
    
    // PERBAIKAN: Hapus '/flutter' di awal string rute
    Route::post('/wisatawan/bookmarks/toggle', [ApiFlutterController::class, 'toggleBookmark']);
    Route::post('/wisatawan/pesan-tiket', [ApiFlutterController::class, 'pesanTiket']);

    Route::get('/admin/members', [ApiFlutterController::class, 'getAdminMembers']);
    Route::get('/admin/owners', [ApiFlutterController::class, 'getAdminOwners']);
    Route::get('/admin/properties', [ApiFlutterController::class, 'getAdminProperties']);
});

// admin

Route::get('/users', [WisatawanApiController::class, 'index']);
Route::post('/users', [WisatawanApiController::class, 'store']);
Route::patch('/users/{id}/status', [WisatawanApiController::class, 'updateStatus']);
Route::delete('/users/{id}', [WisatawanApiController::class, 'destroy']);

// --- CRUD WISATA (Tabel: tempat_wisatas) ---
Route::get('/wisata', [WisataApiController::class, 'index']);
Route::post('/wisata', [WisataApiController::class, 'store']);
Route::patch('/wisata/{id}/approve', [WisataApiController::class, 'approve']);
Route::delete('/wisata/{id}', [WisataApiController::class, 'destroy']);