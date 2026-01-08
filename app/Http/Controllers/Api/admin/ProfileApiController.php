<?php

namespace App\Http\Controllers\Api\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileApiController extends Controller {

    // 1. LIHAT SEMUA USER
    public function index() {
        return response()->json([
            'success' => true,
            'data'    => User::all()
        ], 200);
    }

    // 2. TAMBAH USER BARU (POST)
    public function store(Request $request) {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'bio'      => $request->bio ?? '-', 
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil dibuat!',
            'data'    => $user
        ], 201);
    }

    // 3. EDIT PROFILE (PUT)
    public function update(Request $request, $id) {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false, 
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $user->update([
            'name'     => $request->name ?? $user->name,
            'email'    => $request->email ?? $user->email,
            'bio'      => $request->bio ?? $user->bio,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil diupdate!',
            'data'    => $user
        ], 200);
    }

    // 4. HAPUS PROFILE (DELETE)
    public function destroy($id) {
        $user = User::find($id);
        
        if (!$user) {
            return response()->json([
                'success' => false, 
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil dihapus!'
        ], 200);
    }
}