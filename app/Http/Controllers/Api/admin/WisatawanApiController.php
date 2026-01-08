<?php

namespace App\Http\Controllers\Api\admin; 

use App\Http\Controllers\Controller;
use App\Models\Wisatawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WisatawanApiController extends Controller 
{
    // 1. LIHAT SEMUA USER
    public function index() {
        return response()->json([
            'success' => true,
            'data'    => Wisatawan::all()
        ], 200);
    }

    // 2. TAMBAH USER BARU
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

        return response()->json(['success' => true, 'message' => 'User Berhasil Ditambah', 'data' => $user], 201);
    }

    // 3. EDIT DATA USER
    public function update(Request $request, $id) {
        $user = Wisatawan::where('id_wisatawan', $id)->first();
        if (!$user) return response()->json(['message' => 'User tidak ditemukan'], 404);

        $user->update([
            'nama'     => $request->nama ?? $user->nama,
            'email'    => $request->email ?? $user->email,
            'no_hp'    => $request->no_hp ?? $user->no_hp,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return response()->json(['success' => true, 'message' => 'Data berhasil diupdate!', 'data' => $user], 200);
    }

    // 4. KHUSUS UPDATE STATUS
    public function updateStatus(Request $request, $id) {
        $user = Wisatawan::where('id_wisatawan', $id)->first();
        if (!$user) return response()->json(['message' => 'User tidak ditemukan'], 404);

        $user->update(['status' => $request->status]);
        
        return response()->json([
            'success' => true, 
            'message' => 'Status berhasil diubah!', 
            'data' => $user
        ], 200);
    }

    // 5. HAPUS USER
    public function destroy($id) {
        $user = Wisatawan::where('id_wisatawan', $id)->first();
        if (!$user) return response()->json(['message' => 'User tidak ditemukan'], 404);
        
        $user->delete();
        return response()->json(['success' => true, 'message' => 'User Berhasil Dihapus'], 200);
    }
}