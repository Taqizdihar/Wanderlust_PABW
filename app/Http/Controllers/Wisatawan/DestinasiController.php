<?php

namespace App\Http\Controllers\Wisatawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempatWisata;

class DestinasiController extends Controller
{
    public function index()
    {
        // Ambil semua destinasi dengan paginasi
        $semuaDestinasi = TempatWisata::with(['fotoTempatWisatas', 'penilaians'])
            ->orderBy('nama_tempat', 'asc')
            ->paginate(12);

        // View ini (destinasi.blade.php) perlu Anda buat
        return view('destinasi', compact('semuaDestinasi'));
    }
}