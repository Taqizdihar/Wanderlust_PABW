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
        $request->validate([
            'nama'     => 'required',
            'email'    => 'required|email|unique:wisatawan,email',
            'password' => 'required',
            'no_hp'    => 'required'
        ]);

        $user = Wisatawan::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password), 
            'no_hp'    => $request->no_hp,
            'status'   => 'AKTIF' 
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User Berhasil Ditambah',
            'data'    => $user
        ], 201);
    }

    // 6. EDIT / UPDATE WISATAWAN (PUT /api/users/{id})
    public function update(Request $request, $id) {
        $user = Wisatawan::find($id);

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        $user->update([
            'nama'     => $request->nama ?? $user->nama,
            'email'    => $request->email ?? $user->email,
            'no_hp'    => $request->no_hp ?? $user->no_hp,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Wisatawan berhasil diupdate!',
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

    // --- TAMBAHAN BARU: GANTI STATUS USER (PATCH /api/users/{id}/status) ---
    public function updateStatus(Request $request, $id) {
        $user = Wisatawan::find($id);

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        // Kita update kolom 'status' (sesuai yang kamu set di store tadi)
        $user->update([
            'status' => $request->status ?? $user->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status user berhasil diperbarui!',
            'data'    => $user
        ], 200);
    }
}