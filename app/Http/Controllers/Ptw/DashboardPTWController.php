<?php

namespace App\Http\Controllers\Ptw;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TempatWisata;
use App\Models\Transaksi;

class DashboardPTWController extends Controller {
    public function index() {
        $user = Auth::user();

        $ptw = $user->pemilikTempatWisata;

        if (!$ptw) {
            abort(403, 'Profil Pemilik Tempat Wisata belum lengkap.');
        }

        $totalProperties = TempatWisata::where('id_ptw', $ptw->id_ptw)->count();

        $venueIds = TempatWisata::where('id_ptw', $ptw->id_ptw)->pluck('id_wisata');
        $totalTicketsSold = 0;
        $totalRevenue = 0;
        $totalVisitors = 0;
        $transactions = Transaksi::whereHas('tiket', function($q) use ($venueIds) {
            $q->whereIn('id_wisata', $venueIds);
        })->get();
        $totalTicketsSold = $transactions->count(); 
        $totalRevenue = $transactions->sum('total_harga'); 
        $totalVisitors = $totalTicketsSold; 

        return view('ptw.dashboardPTW', compact(
            'user', 
            'ptw', 
            'totalProperties', 
            'totalTicketsSold', 
            'totalRevenue', 
            'totalVisitors'
        ));
    }
}