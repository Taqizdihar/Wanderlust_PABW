<?php

namespace App\Http\Controllers\Ptw;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\TempatWisata;
use App\Models\FotoTempatWisata;

class EditPropertyPTWController extends Controller {
    public function edit($id) {
        $user = Auth::user();
        $ptw = $user->pemilikTempatWisata;

        $property = TempatWisata::with('fotoTempatWisata')->where('id_wisata', $id)->where('id_ptw', $ptw->id_ptw)->firstOrFail();

        $categories = ['Nature', 'Historical', 'Amusement Park', 'Education', 'Other'];

        return view('ptw.edit_property', compact('user', 'ptw', 'property', 'categories'));
    }

    public function update(Request $request, $id) {
        $user = Auth::user();
        $ptw = $user->pemilikTempatWisata;

        $property = TempatWisata::where('id_wisata', $id)->where('id_ptw', $ptw->id_ptw)->firstOrFail();

        $request->validate([
            'nama_wisata' => 'nullable|string|max:255',
            'category' => 'nullable',
            'alamat_wisata' => 'nullable',
            'waktu_buka' => 'nullable',
            'waktu_tutup' => 'nullable',
            'deskripsi' => 'nullable',
            'foto_wisata.*' => 'image|max:2048', 
        ]);

        if ($request->filled('nama_wisata')) $property->nama_wisata = $request->nama_wisata;
        if ($request->filled('category')) $property->jenis_wisata = $request->category;
        if ($request->filled('alamat_wisata')) $property->alamat_wisata = $request->alamat_wisata;
        if ($request->filled('waktu_buka')) $property->waktu_buka = $request->waktu_buka;
        if ($request->filled('waktu_tutup')) $property->waktu_tutup = $request->waktu_tutup;
        if ($request->filled('deskripsi')) $property->deskripsi = $request->deskripsi;

        $property->save();

        if ($request->hasFile('foto_wisata')) {
            foreach ($request->file('foto_wisata') as $index => $file) {
                $urutan = $index + 1;
                $oldPhoto = FotoTempatWisata::where('id_wisata', $id)
                            ->where('urutan', $urutan)
                            ->first();
                if ($oldPhoto && File::exists(public_path($oldPhoto->foto_wisata))) {
                    File::delete(public_path($oldPhoto->foto_wisata));
                }
                $filename = time() . '_wisata_' . $id . '_' . $urutan . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/wisata'), $filename);

                FotoTempatWisata::updateOrCreate(
                    ['id_wisata' => $id, 'urutan' => $urutan],
                    ['foto_wisata' => 'images/wisata/' . $filename]
                );
            }
        }

        return redirect()->route('properties.ptw')->with('success', 'Property updated successfully!');
    }
}