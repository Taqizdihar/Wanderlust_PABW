<?php
public function index(Request $request)
{
    $page = $request->query('page', 'dashboard');
    
    // Ambil user yang login, jika tidak ada (untuk testing), ambil user pertama
    $user = auth()->user() ?? User::first(); 
    
    $users = Wisatawan::all(); 
    $wisatas = Wisata::all();

    $wisata_single = null;
    if($page == 'review_detail' && $request->has('id')) {
        $wisata_single = Wisata::find($request->query('id'));
    }

    $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];
    $chartData = [45, 70, 55, 90, 130, 110];

    return view('admin', compact('page', 'user', 'users', 'wisatas', 'wisata_single', 'chartLabels', 'chartData'));
}