<?php

namespace App\Http\Controllers\Wisatawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaketWisata; 
use App\Models\Transaksi; 

class PesanTiketController extends Controller
{
    public function showForm($idPaket)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk memesan tiket.');
        }

        $paket = PaketWisata::findOrFail($idPaket);
        return view('pemesanan', compact('paket'));
    }

    public function store(Request $request)
    {
        // ... (Logika validasi dan simpan transaksi) ...
        return back()->with('success', 'Pemesanan berhasil!');
    }

    // Fungsi untuk menampilkan riwayat transaksi (tautan 'Pesan Tiket' di header)
    public function riwayat()
    {
        $riwayatTransaksi = Transaksi::where('id_wisatawan', Auth::user()->id_wisatawan)
                                     ->orderByDesc('created_at')
                                     ->get();
                                     
        // View ini (riwayat_transaksi.blade.php) perlu Anda buat
        return view('riwayat_transaksi', compact('riwayatTransaksi'));
    }
}