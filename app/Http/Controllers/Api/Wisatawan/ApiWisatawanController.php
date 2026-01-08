<?php

namespace App\Http\Controllers\Api\Wisatawan;

use App\Http\Controllers\Controller;
use App\Models\TempatWisata;
use App\Models\Bookmark;
use App\Models\Penilaian;
use App\Models\Transaksi;
use App\Models\TiketTempatWisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiWisatawanController extends Controller
{
    // --- 1. FITUR EXPLORE (PUBLIK) ---
    
    public function index()
    {
        $wisata = TempatWisata::with(['fotoTempatWisata'])->get();
        return response()->json([
            'status' => 'success',
            'data'   => $wisata
        ], 200);
    }

    public function detail($id)
    {
        $detail = TempatWisata::with(['fotoTempatWisata', 'tiketTempatWisata', 'penilaian'])
                    ->find($id);

        if (!$detail) {
            return response()->json(['message' => 'Destinasi tidak ditemukan'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $detail], 200);
    }

    // --- 2. FITUR WISATAWAN (BUTUH LOGIN) ---

    // Toggle Bookmark (Tambah/Hapus)

    public function profile()
{
    $user = Auth::user()->load('wisatawan'); 
    return response()->json([
        'status' => 'success',
        'data'   => $user
    ], 200);
}

    public function storeBookmark(Request $request)
    {
        $id_wisatawan = Auth::user()->wisatawan->id_wisatawan;

        $exists = Bookmark::where('id_wisatawan', $id_wisatawan)
                          ->where('id_wisata', $request->id_wisata)
                          ->first();

        if ($exists) {
            $exists->delete();
            return response()->json(['message' => 'Berhasil dihapus dari favorit'], 200);
        }

        $bookmark = Bookmark::create([
            'id_wisatawan' => $id_wisatawan,
            'id_wisata'    => $request->id_wisata,
            'tanggal_simpan' => now()
        ]);

        return response()->json(['message' => 'Berhasil disimpan ke favorit', 'data' => $bookmark], 201);
    }

    // Booking Tiket
    public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_tiket' => 'required',
            'jumlah_tiket' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) return response()->json($validator->errors(), 422);

        $tiket = TiketTempatWisata::findOrFail($request->id_tiket);
        
        $transaksi = Transaksi::create([
            'id_wisatawan'      => Auth::user()->wisatawan->id_wisatawan,
            'id_tiket'          => $request->id_tiket,
            'jumlah_tiket'      => $request->jumlah_tiket,
            'total_harga'       => $tiket->harga * $request->jumlah_tiket,
            'status_transaksi'  => 'pending',
            'tanggal_transaksi' => now(),
            'kode_transaksi'    => 'TRX-' . time()
        ]);

        return response()->json(['message' => 'Checkout Berhasil', 'data' => $transaksi], 201);
    }

    // Beri Rating & Ulasan
    public function beriUlasan(Request $request)
    {
        $ulasan = Penilaian::create([
            'id_wisatawan'      => Auth::user()->wisatawan->id_wisatawan,
            'id_wisata'         => $request->id_wisata,
            'penilaian'         => $request->penilaian, // 1-5
            'ulasan'            => $request->ulasan,
            'status_penilaian'  => 'aktif',
            'tanggal_penilaian' => now()
        ]);

        return response()->json(['message' => 'Terima kasih atas ulasannya!', 'data' => $ulasan], 201);
    }
}