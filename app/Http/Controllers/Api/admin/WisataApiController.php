<?php

namespace App\Http\Controllers\Api\admin; 

use App\Http\Controllers\Controller;
use App\Models\Wisata; 
use Illuminate\Http\Request;

class WisataApiController extends Controller {
    
    // 1. LIHAT SEMUA WISATA
    public function index() {
        return response()->json([
            'success' => true,
            'data'    => Wisata::all()
        ], 200);
    }

    // 2. TAMBAH / AJUKAN WISATA
    public function store(Request $request) {
        $wisata = Wisata::create([
            'id_ptw'        => $request->id_ptw ?? 1, 
            'nama_tempat'   => $request->nama_tempat,
            'alamat_tempat' => $request->alamat_tempat,
            'deskripsi'     => $request->deskripsi,
            'status'        => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Wisata berhasil diajukan!',
            'data'    => $wisata
        ], 201);
    }

    // 3. SETUJUI WISATA (APPROVE)
    public function approve($id) {
        $wisata = Wisata::find($id);

        if (!$wisata) {
            return response()->json([
                'success' => false,
                'message' => 'Data wisata tidak ditemukan'
            ], 404);
        }

        $wisata->status = 'approved';
        $wisata->save();

        return response()->json([
            'success' => true,
            'message' => 'Wisata berhasil disetujui!',
            'data'    => $wisata
        ], 200);
    }

    // 4. HAPUS WISATA
    public function destroy($id) {
        $wisata = Wisata::find($id);
        if (!$wisata) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        
        $wisata->delete();
        return response()->json(['success' => true, 'message' => 'Wisata berhasil dihapus'], 200);
    }

    // 5. EDIT WISATA (Ini yang baru ya beb!)
    public function update(Request $request, $id) {
        $wisata = Wisata::find($id);

        if (!$wisata) {
            return response()->json([
                'success' => false,
                'message' => 'Data wisata tidak ditemukan'
            ], 404);
        }

        // Pakai update biar simple
        $wisata->update([
            'nama_tempat'   => $request->nama_tempat ?? $wisata->nama_tempat,
            'alamat_tempat' => $request->alamat_tempat ?? $wisata->alamat_tempat,
            'deskripsi'     => $request->deskripsi ?? $wisata->deskripsi,
            'status'        => $request->status ?? $wisata->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data wisata berhasil diupdate!',
            'data'    => $wisata
        ], 200);
    }
}