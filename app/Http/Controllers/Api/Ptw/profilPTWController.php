<?php

namespace App\Http\Controllers\Api\Ptw;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class profilPTWController extends Controller
{
    /**
     * Menampilkan data profil PTW yang sedang login.
     */
    public function show()
    {
        // Mengambil user beserta data relasi pemiliknya
        $user = Auth::user()->load('pemilikTempatWisata');

        return response()->json([
            'success' => true,
            'message' => 'Data profil berhasil diambil',
            'data' => $user
        ], 200);
    }

    /**
     * Mengupdate data profil PTW.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $ptw = $user->pemilikTempatWisata;

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            // Field berikut diasumsikan ada di tabel pemilik_tempat_wisata
            'no_telp'  => 'nullable|string',
            'alamat'   => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        // 1. Update data di tabel Users
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // 2. Update data di tabel Pemilik Tempat Wisata (jika ada)
        if ($ptw) {
            $ptw->update($request->only(['no_telp', 'alamat']));
        }

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'data'    => $user->load('pemilikTempatWisata')
        ], 200);
    }
}