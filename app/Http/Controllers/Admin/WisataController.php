<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wisata;
use App\Models\User;
use Illuminate\Http\Request;

class WisataController extends Controller 
{
    // Halaman List Wisata
    public function index() {
        $wisatas = Wisata::all(); 
        // Arahkan ke view admin.admin sesuai folder kamu
        return view('admin.admin', [
            'page' => 'wisata', 
            'wisatas' => $wisatas,
            'user' => auth()->user() ?? User::first()
        ]);
    }

    public function store(Request $request) {
    $request->validate([
        'nama_wisata' => 'required',
        'pemilik'     => 'required', // Ini nama dari inputan form Blade kamu
        'deskripsi'   => 'required',
    ]);

    \App\Models\Wisata::create([
        'nama_tempat'   => $request->nama_wisata,
        'alamat_tempat' => $request->pemilik, // Kita simpan data "Pemilik" ke kolom "alamat_tempat" biar gak error
        'deskripsi'     => $request->deskripsi,
        'status'        => 'pending'
    ]);

    return redirect()->route('admin.index', ['page' => 'wisata'])->with('success', 'Wisata berhasil disimpan!');
}

    // Proses Approve (Update Status jadi Selesai/Approved)
    public function approve($id) {
        $wisata = Wisata::findOrFail($id);
        $wisata->update(['status' => 'approved']);
        return redirect()->route('admin.index', ['page' => 'wisata'])->with('success', 'Wisata telah disetujui!');
    }

    // Proses Revisi (Update Status jadi Revisi)
    public function revisi($id) {
        $wisata = Wisata::findOrFail($id);
        $wisata->update(['status' => 'revisi']);
        return redirect()->route('admin.index', ['page' => 'wisata'])->with('success', 'Wisata diminta untuk revisi.');
    }

    // Hapus Wisata (Delete)
    public function destroy($id) {
        $wisata = Wisata::findOrFail($id);
        $wisata->delete();
        return redirect()->route('admin.index', ['page' => 'wisata'])->with('success', 'Wisata berhasil dihapus!');
    }
}