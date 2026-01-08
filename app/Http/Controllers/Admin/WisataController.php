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

    // Simpan Wisata Baru (Create)
    public function store(Request $request) {
        $request->validate([
            'nama_wisata' => 'required',
            'pemilik' => 'required',
            'deskripsi' => 'required',
        ]);

        Wisata::create([
            'nama_wisata' => $request->nama_wisata,
            'pemilik'     => $request->pemilik,
            'deskripsi'   => $request->deskripsi,
            'status'      => 'pending' // Status awal otomatis pending
        ]);

        return redirect()->route('admin.index', ['page' => 'wisata'])->with('success', 'Wisata berhasil ditambahkan!');
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