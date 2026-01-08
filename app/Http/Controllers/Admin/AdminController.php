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
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:wisatawan,email', 
        ]);

        Wisatawan::create([
            'nama'   => $request->nama,
            'email'  => $request->email,
            'status' => 'AKTIF', 
        ]);

        return redirect()->route('admin.index', ['page' => 'users'])
                         ->with('success', "Wisatawan " . $request->nama . " berhasil ditambahkan!");
    }

    public function toggleStatus($id)
    {
        $user = Wisatawan::find($id);
        if ($user) {
            $user->status = ($user->status == 'AKTIF') ? 'NON-AKTIF' : 'AKTIF';
            $user->save();
            
            return back()->with('success', "Status " . $user->nama . " berhasil diubah!");
        }
        return back()->with('error', "Wisatawan tidak ditemukan!");
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