<?php

namespace App\Http\Controllers\Api\Ptw;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TempatWisata;
use Illuminate\Support\Facades\Validator;

class managePropertiesController extends Controller {

    public function index() {
        $user = Auth::user();
        $ptw = $user->pemilikTempatWisata;

        $properties = TempatWisata::where('id_ptw', $ptw->id_ptw)->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar tempat wisata berhasil diambil',
            'data' => $properties
        ], 200);
    }

    public function store(Request $request) {
        $user = Auth::user();
        $ptw = $user->pemilikTempatWisata;

        $validator = Validator::make($request->all(), [
            'nama_wisata' => 'required|string|max:255',
            'alamat_wisata' => 'required|string',
            'kota' => 'required|string',
            'jenis_wisata' => 'required|string',
            'waktu_buka' => 'required',
            'waktu_tutup' => 'required',
            'deskripsi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $property = TempatWisata::create([
            'id_ptw' => $ptw->id_ptw,
            'nama_wisata' => $request->nama_wisata,
            'alamat_wisata' => $request->alamat_wisata,
            'kota' => $request->kota,
            'jenis_wisata' => $request->jenis_wisata,
            'waktu_buka' => $request->waktu_buka,
            'waktu_tutup' => $request->waktu_tutup,
            'deskripsi' => $request->deskripsi,
            'status_wisata' => 'pending',
            'catatan_revisi' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tempat wisata berhasil diajukan dan berstatus pending.',
            'data' => $property
        ], 201);
    }

    public function show($id) {
        $user = Auth::user();
        $ptw = $user->pemilikTempatWisata;

        $property = TempatWisata::where('id_wisata', $id)
                                ->where('id_ptw', $ptw->id_ptw)
                                ->first();

        if (!$property) {
            return response()->json(['message' => 'Data tidak ditemukan atau Anda tidak memiliki akses'], 404);
        }

        return response()->json(['success' => true, 'data' => $property], 200);
    }

    public function update(Request $request, $id) {
        $user = Auth::user();
        $ptw = $user->pemilikTempatWisata;

        $property = TempatWisata::where('id_wisata', $id)
                                ->where('id_ptw', $ptw->id_ptw)
                                ->first();

        if (!$property) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $property->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data tempat wisata berhasil diperbarui',
            'data' => $property
        ], 200);
    }

    public function destroy($id) {
        $user = Auth::user();
        $ptw = $user->pemilikTempatWisata;

        $property = TempatWisata::where('id_wisata', $id)
                                ->where('id_ptw', $ptw->id_ptw)
                                ->first();

        if (!$property) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $property->delete();

        return response()->json(['success' => true, 'message' => 'Tempat wisata berhasil dihapus'], 200);
    }
}