<?php

namespace App\Http\Controllers\Api\admin; 

use App\Http\Controllers\Controller;
use App\Models\Wisatawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WisatawanApiController extends Controller 
{
    // 1. LIHAT SEMUA USER (GET /api/users)
    public function index() {
        $users = Wisatawan::all();
        return response()->json([
            'success' => true,
            'message' => 'Daftar semua wisatawan berhasil diambil',
            'data'    => $users
        ], 200);
    }

    // 2. LIHAT DETAIL 1 USER (GET /api/users/{id})
    public function show($id) {
        $user = Wisatawan::find($id);
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }
        return response()->json($user, 200);
    }

    // 3. TAMBAH USER BARU (POST /api/users)
    public function store(Request $request) {
        // Validasi simpel biar gak error kalau datanya kosong
        $request->validate([
            'nama'     => 'required',
            'email'    => 'required|email|unique:wisatawan,email',
            'password' => 'required',
            'no_hp'    => 'required'
        ]);

        $user = Wisatawan::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Lebih aman pakai Hash
            'no_hp'    => $request->no_hp,
            'status'   => 'AKTIF' 
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User Berhasil Ditambah',
            'data'    => $user
        ], 201);
    }

    // 4. UPDATE STATUS AKTIF/NON-AKTIF (PATCH /api/users/{id}/status)
    public function updateStatus($id) {
        $user = Wisatawan::find($id);
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }
        
        // Logika ganti status otomatis
        $user->status = ($user->status == 'AKTIF') ? 'NON-AKTIF' : 'AKTIF';
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Status Berhasil Diubah jadi ' . $user->status,
            'data'    => $user
        ], 200);
    }

    // 5. HAPUS USER (DELETE /api/users/{id})
    public function destroy($id) {
        $user = Wisatawan::find($id);
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }
        
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'User Berhasil Dihapus'
        ], 200);
    }
}