<?php

namespace App\Http\Controllers; 

use App\Models\Wisata;
use App\Models\User;
use Illuminate\Http\Request;

class WisataController extends Controller 
{
    public function index() {
        $wisatas = Wisata::all(); 
        return view('admin', [
            'page' => 'wisata', 
            'wisatas' => $wisatas,
            'user' => auth()->user() ?? User::first()
        ]);
    }

    public function review($id) {
        $wisata = Wisata::findOrFail($id);
        return view('admin', [
            'page' => 'review_detail', 
            'wisata' => $wisata,
            'user' => auth()->user() ?? User::first()
        ]);
    }

    public function approve($id) {
        $wisata = Wisata::findOrFail($id);
        $wisata->status = 'approved'; 
        $wisata->save();
        return redirect()->route('wisata.index')->with('success', 'Wisata "' . $wisata->nama_wisata . '" telah disetujui!');
    }

    public function revisi($id) {
        $wisata = Wisata::findOrFail($id);
        $wisata->status = 'pending'; 
        $wisata->save();
        return redirect()->route('wisata.index')->with('success', 'Wisata dikembalikan (Status: Pending)!');
    }

    public function destroy($id) {
        $wisata = Wisata::findOrFail($id);
        $nama = $wisata->nama_wisata;
        $wisata->delete(); 
        return redirect()->route('wisata.index')->with('success', 'Wisata "' . $nama . '" berhasil dihapus!');
    }

    public function create() {
        return view('admin', [
            'page' => 'tambah_wisata',
            'user' => auth()->user() ?? User::first()
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'nama_wisata' => 'required',
            'pemilik' => 'required',
            'deskripsi' => 'required',
        ]);

        Wisata::create([
            'nama_wisata' => $request->nama_wisata,
            'pemilik' => $request->pemilik,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending',
        ]);

        return redirect()->route('wisata.index')->with('success', 'Wisata baru berhasil ditambahkan!');
    }
}