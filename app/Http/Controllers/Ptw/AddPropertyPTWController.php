<?php

namespace App\Http\Controllers\Ptw;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TempatWisata;
use App\Models\FotoTempatWisata;

class AddPropertyPTWController extends Controller {
    public function index() {
        $user = Auth::user();
        $ptw = $user->pemilikTempatWisata;
        $categories = ['Nature', 'Historical', 'Amusement Park', 'Education', 'Other'];
        return view('ptw.add_property', compact('categories', 'user', 'ptw'));
    }

    public function store(Request $request){
        $user = Auth::user();
        $ptw = $user->pemilikTempatWisata;

        $request->validate([
            'nama_wisata' => 'required|string|max:255',
            'category' => 'required',
            'alamat_wisata' => 'required',
            'waktu_buka' => 'required',
            'waktu_tutup' => 'required',
            'deskripsi' => 'required',
            'foto_wisata' => 'required',
            'foto_wisata.*' => 'image|max:2048', 
        ]);

        $wisata = TempatWisata::create([
            'id_ptw' => $ptw->id_ptw,
            'kategori_wisata_id' => 1,
            'nama_wisata' => $request->nama_wisata,
            'alamat_wisata' => $request->alamat_wisata,
            'kota' => 'Bandung',
            'jenis_wisata' => $request->category,
            'waktu_buka' => $request->waktu_buka,
            'waktu_tutup' => $request->waktu_tutup,
            'deskripsi' => $request->deskripsi,
            'status_pengajuan' => 'pending'
        ]);

        if ($request->hasFile('foto_wisata')) {
            foreach ($request->file('foto_wisata') as $index => $file) {
                $filename = time() . '_wisata_' . $index . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/wisata'), $filename);
                FotoTempatWisata::create([
                    'id_wisata' => $wisata->id_wisata,
                    'foto_wisata' => 'images/wisata/' . $filename,
                    'urutan' => $index + 1
                ]);
            }
        }

        return redirect()->route('properties.ptw')->with('success', 'Property added successfully. You can now add tickets.');
    }
}