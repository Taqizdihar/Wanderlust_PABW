<?php

namespace App\Http\Controllers\Api\admin;

use App\Http\Controllers\Controller;
use App\Models\Wisatawan;
use Illuminate\Http\Request;

class WisatawanApiController extends Controller 
{
    public function index() {
        return response()->json(Wisatawan::all(), 200);
    }

    public function store(Request $request) {
        $user = Wisatawan::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => bcrypt($request->password ?? 'password123'),
            'no_hp'    => $request->no_hp,
            'status'   => 'AKTIF'
        ]);
        return response()->json(['message' => 'User Berhasil Ditambah', 'data' => $user], 201);
    }

    public function updateStatus($id) {
        $user = Wisatawan::find($id);
        if (!$user) return response()->json(['message' => 'User tidak ditemukan'], 404);
        $user->status = ($user->status == 'AKTIF') ? 'NON-AKTIF' : 'AKTIF';
        $user->save();
        return response()->json(['message' => 'Status Berhasil Diubah', 'data' => $user], 200);
    }

    public function destroy($id) {
        $user = Wisatawan::find($id);
        if (!$user) return response()->json(['message' => 'User tidak ditemukan'], 404);
        $user->delete();
        return response()->json(['message' => 'User Berhasil Dihapus'], 200);
    }
}