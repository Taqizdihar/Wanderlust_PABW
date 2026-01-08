<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wisata;
use Illuminate\Http\Request;

class WisataApiController extends Controller {
    public function index() {
        return response()->json(Wisata::all(), 200);
    }

    public function store(Request $request) {
        $wisata = Wisata::create([
            'nama_tempat' => $request->nama_tempat,
            'alamat_tempat' => $request->alamat_tempat,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending'
        ]);
        return response()->json(['message' => 'Wisata Berhasil Ditambah', 'data' => $wisata], 201);
    }

    // APPROVE WISATA (Pending -> Approved)
    public function approve($id) {
        $wisata = Wisata::find($id);
        if (!$wisata) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        
        $wisata->status = 'approved';
        $wisata->save();
        return response()->json(['message' => 'Wisata Berhasil Di-approve', 'data' => $wisata], 200);
    }
}