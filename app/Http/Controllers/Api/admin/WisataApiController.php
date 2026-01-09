<?php

namespace App\Http\Controllers\Api\admin; 

use App\Http\Controllers\Controller;
use App\Models\Wisata; 
use Illuminate\Http\Request;

class WisataApiController extends Controller {
    
    public function index() {
        return response()->json([
            'success' => true,
            'data'    => Wisata::all()
        ], 200);
    }
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

    public function approve(Request $request, $id) {
        $wisata = Wisata::where('id_tempat', $id)->first();

        if (!$wisata) {
            return response()->json([
                'success' => false,
                'message' => 'Data wisata tidak ditemukan'
            ], 404);
        }

        $wisata->status = $request->status ?? 'approved';
        $wisata->save();

        return response()->json([
            'success' => true,
            'message' => 'Status wisata berhasil diperbarui jadi ' . $wisata->status,
            'data'    => $wisata
        ], 200);
    }
    public function updateStatus(Request $request, $id) {
        $wisata = Wisata::where('id_tempat', $id)->first();

        if (!$wisata) {
            return response()->json([
                'success' => false,
                'message' => 'Data wisata tidak ditemukan'
            ], 404);
        }

        
        $wisata->update([
            'status' => $request->status 
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diubah menjadi ' . $request->status,
            'data'    => $wisata
        ], 200);
    }
    // untuk  HAPUS WISATA
    public function destroy($id) {
        $wisata = Wisata::find($id);
        if (!$wisata) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        
        $wisata->delete();
        return response()->json(['success' => true, 'message' => 'Wisata berhasil dihapus'], 200);
    }

public function update(Request $request, $id) {
    $wisata = Wisata::where('id_tempat', $id)->first();

    if (!$wisata) {
        return response()->json([
            'success' => false,
            'message' => 'Data wisata tidak ditemukan (ID: '.$id.')' 
        ], 404);
    }

    $wisata->update([
        'nama_tempat'   => $request->nama_tempat ?? $wisata->nama_tempat,
        'alamat_tempat' => $request->alamat_tempat ?? $wisata->alamat_tempat,
        'deskripsi'     => $request->deskripsi ?? $wisata->deskripsi,
        'status'        => $request->status ?? $wisata->status,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Data Wisata berhasil diupdate!',
        'data'    => $wisata
    ], 200);
}
}