<?php

namespace App\Http\Controllers\Wisatawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProfilController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();
        $wisatawan = $user->wisatawan;

       $usia = null;
        if ($wisatawan && $wisatawan->tanggal_lahir) {
            $birthDate = Carbon::parse($wisatawan->tanggal_lahir);
            
            // Menggunakan diffInYears() yang sudah pasti menghasilkan bilangan bulat (integer)
            $usiaTahun = $birthDate->diffInYears(Carbon::now());
            
            $usia = $usiaTahun . ' Tahun'; // Format output menjadi "30 Tahun"
        }

        return view('profil', compact('user', 'wisatawan', 'usia'));
    }
}