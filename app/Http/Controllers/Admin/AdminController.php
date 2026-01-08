<?php

namespace App\Http\Controllers;


namespace App\Http\Controllers\Admin; // Harus ada kata \Admin

use App\Http\Controllers\Controller; // Tambahkan ini biar dia kenal induknya
use Illuminate\Http\Request;
// ... sisanya sama
use App\Models\User;
use App\Models\Wisata;
use App\Models\Wisatawan; 

class AdminController extends Controller
{
    public function index(Request $request)
{
    $page = $request->query('page', 'dashboard');
    
    // Ambil user login, kalau belum login ambil user pertama di DB
    $user = auth()->user() ?? \App\Models\User::first(); 
    
    // Pakai try-catch biar kalau tabel 'wisatawan' atau 'tempat_wisatas' belum ada, gak langsung 500
    try {
        $users = \App\Models\Wisatawan::all() ?? collect(); 
        $wisatas = \App\Models\Wisata::all() ?? collect();
    } catch (\Exception $e) {
        $users = collect();
        $wisatas = collect();
    }

    $wisata_single = null;
    if($page == 'review_detail' && $request->has('id')) {
        $wisata_single = \App\Models\Wisata::find($request->query('id'));
    }

    $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];
    $chartData = [45, 70, 55, 90, 130, 110];

    // Tambahkan 'admin.' sebelum nama file karena dia ada di dalam folder admin
return view('admin.admin', compact('page', 'user', 'users', 'wisatas', 'wisata_single', 'chartLabels', 'chartData'));
}
  public function storeUser(Request $request)
{
    // 1. Validasi
    $request->validate([
        'nama' => 'required',
        'email' => 'required|email|unique:wisatawan,email', 
    ]);

    // 2. Simpan Data
    $user = Wisatawan::create([
        'nama'   => $request->nama,
        'email'  => $request->email,
        'status' => 'AKTIF', 
    ]);

    // 3. CEK: Apakah request datang dari API (Postman) atau Browser?
    if ($request->expectsJson()) {
        return response()->json([
            'success' => true,
            'message' => "Wisatawan " . $request->nama . " berhasil ditambahkan!",
            'data'    => $user
        ], 201);
    }

    // Kalau dari browser, tetap redirect seperti biasa
    return redirect()->route('admin.index', ['page' => 'users'])
                     ->with('success', "Wisatawan " . $request->nama . " berhasil ditambahkan!");
}
  public function destroy($id)
{
    $user = \App\Models\Wisatawan::find($id);
    if ($user) {
        $user->delete();
        return back()->with('success', 'Data wisatawan berhasil dihapus!');
    }
    return back()->with('error', 'Data tidak ditemukan!');
}
}