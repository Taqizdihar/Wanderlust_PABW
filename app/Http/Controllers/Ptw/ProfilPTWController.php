<?php

namespace App\Http\Controllers\Ptw;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfilPTWController extends Controller {
    public function index() {
        $user = Auth::user();
        $ptw = $user->pemilikTempatWisata;
        return view('ptw.profilPTW', compact('user', 'ptw'));
    }

    public function edit() {
        $user = Auth::user();
        $ptw = $user->pemilikTempatWisata;
        return view('ptw.edit_profil', compact('user', 'ptw'));
    }

    public function update(Request $request) {
        $user = Auth::user();
        $ptw = $user->pemilikTempatWisata;

        if ($request->filled('nama')) $user->nama = $request->nama;
        if ($request->filled('email')) $user->email = $request->email;
        if ($request->filled('nomor_telepon')) $user->nomor_telepon = $request->nomor_telepon;

        if ($request->hasFile('foto_profil')) {            
            $file = $request->file('foto_profil');
            $filename = time() . '_profil.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/logos'), $filename);
            $user->foto_profil = 'images/logos/' . $filename;
        }

        $user->save();

        if ($request->filled('jabatan')) $ptw->jabatan = $request->jabatan;
        if ($request->filled('nama_organisasi')) $ptw->nama_organisasi = $request->nama_organisasi;
        if ($request->filled('alamat_bisnis')) $ptw->alamat_bisnis = $request->alamat_bisnis;

        if ($request->hasFile('foto_organisasi')) {
            $file = $request->file('foto_organisasi');
            $filename = time() . '_org.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/logos'), $filename);
            $ptw->foto_organisasi = 'images/logos/' . $filename;
        }

        if ($request->hasFile('siu')) {
            $file = $request->file('siu');
            $filename = time() . '_SIUP.' . $file->getClientOriginalExtension();
            $file->move(public_path('documents'), $filename);
            $ptw->siu = 'documents/' . $filename;
        }

        if ($request->hasFile('npwp')) {
            $file = $request->file('npwp');
            $filename = time() . '_NPWP.' . $file->getClientOriginalExtension();
            $file->move(public_path('documents'), $filename);
            $ptw->npwp = 'documents/' . $filename;
        }

        $ptw->save();

        return redirect()->route('profil.ptw')->with('success', 'Profil berhasil diperbarui!');
    }
}