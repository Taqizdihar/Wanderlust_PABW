<?php

namespace App\Http\Controllers\Wisatawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penilaian;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    // Fungsi untuk menyimpan ulasan dan rating
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return back()->with('error', 'Anda harus login untuk memberikan penilaian.');
        }

        $request->validate([
            'id_tempat' => 'required|exists:tempat_wisatas,id_tempat',
            'penilaian' => 'required|integer|min:1|max:5',
            'ulasan' => 'nullable|string|max:1000',
        ]);
        
        try {
            Penilaian::create([
                'id_wisatawan' => Auth::user()->id_wisatawan,
                'id_tempat' => $request->id_tempat,
                'penilaian' => $request->penilaian,
                'ulasan' => $request->ulasan,
            ]);

            return back()->with('success', 'Penilaian Anda berhasil disimpan.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan penilaian.');
        }
    }

    // Fungsi untuk menampilkan halaman daftar penilaian pengguna
    public function index()
    {
        $penilaians = Auth::user()->penilaians()->with('tempatWisata')->get();
        return view('daftar_penilaian', compact('penilaians'));
    }
}