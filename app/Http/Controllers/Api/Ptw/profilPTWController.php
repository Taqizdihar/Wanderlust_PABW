<?php

namespace App\Http\Controllers\Api\Ptw;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class profilPTWController extends Controller {

    public function show() {
        $user = Auth::user()->load('pemilikTempatWisata');

        return response()->json([
            'success' => true,
            'message' => 'Data profil berhasil diambil',
            'data' => $user
        ], 200);
    }

    public function update(Request $request) {
        $user = Auth::user();
        $ptw = $user->pemilikTempatWisata;

        $validator = Validator::make($request->all(), [
            'nama'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'nomor_telepon'   => 'nullable|string|max:15',
            'password'        => 'nullable|min:6|confirmed',
            'jabatan'         => 'nullable|string',
            'nama_organisasi' => 'nullable|string',
            'alamat_bisnis'   => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->nomor_telepon = $request->nomor_telepon;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        if ($ptw) {
            $ptw->update($request->only([
                'jabatan', 
                'nama_organisasi', 
                'alamat_bisnis'
            ]));
        }

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'data'    => $user->load('pemilikTempatWisata')
        ], 200);
    }
}