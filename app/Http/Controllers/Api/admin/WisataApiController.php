<?php

namespace App\Http\Controllers\Api\admin; // Pastikan folder 'admin' huruf kecil sesuai folder kamu

use App\Http\Controllers\Controller;
use App\Models\Wisata; // Pastikan Model Wisata sudah ada
use Illuminate\Http\Request;

class WisataApiController extends Controller {
    
    public function index() {
        return response()->json(Wisata::all(), 200);
    }

    public function store(Request $request) {
        $wisata = Wisata::create([
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
}