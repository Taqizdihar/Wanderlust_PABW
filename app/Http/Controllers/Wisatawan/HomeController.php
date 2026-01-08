<?php

namespace App\Http\Controllers\Wisatawan;

use App\Http\Controllers\Controller;
use App\Models\TempatWisata;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $wisatawanId = Auth::guard('wisatawan')->check() ? Auth::guard('wisatawan')->user()->id_wisatawan : 0;

            $baseQuery = TempatWisata::with(['fotoTempatWisatas'])
                ->leftJoin('penilaians', 'tempat_wisatas.id_tempat', '=', 'penilaians.id_tempat')
                ->leftJoin('paket_wisatas', 'tempat_wisatas.id_tempat', '=', 'paket_wisatas.id_tempat')
                ->select(
                    'tempat_wisatas.id_tempat',
                    'tempat_wisatas.nama_tempat',
                    'tempat_wisatas.alamat_tempat',
                    'tempat_wisatas.deskripsi',
                    DB::raw('AVG(penilaians.penilaian) as avg_rating'),
                    DB::raw('COUNT(DISTINCT penilaians.id_penilaian) as review_count'),
                    DB::raw('MIN(paket_wisatas.harga) as min_harga')
                )
                ->groupBy('tempat_wisatas.id_tempat', 'tempat_wisatas.nama_tempat', 'tempat_wisatas.alamat_tempat', 'tempat_wisatas.deskripsi');

            $populer = TempatWisata::with(['fotoTempatWisatas'])->take(4)->get();
            $rekomendasi = TempatWisata::inRandomOrder()->take(4)->get();

            $format = function($collection) {
                return $collection->map(function($item) {
                    return (object) [
                        'id_tempat' => $item->id_tempat,
                        'nama' => $item->nama_tempat,
                        'lokasi' => $item->alamat_tempat,
                        'rating' => number_format($item->avg_rating ?? 0, 1),
                        'reviews' => $item->review_count ?? 0,
                        'harga' => $item->min_harga ?? 0,
                        'foto' => $item ? $item->file_path : 'images/default.jpg',
                        'is_bookmarked' => (bool)$item->is_bookmarked
                    ];
                });
            };

            $populer = $format($populer);
            $rekomendasi = $format($rekomendasi);

            return view('Wisatawan.home', compact('populer', 'rekomendasi'));

        } catch (\Exception $e) {
            // Jika error, tampilkan pesan errornya di layar untuk debug
            dd("Error ditemukan: " . $e->getMessage());
        }
    }
}