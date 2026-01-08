<?php

namespace App\Http\Controllers\Wisatawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempatWisata;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Ambil ID Wisatawan yang sedang login (untuk fitur bookmark)
        // Jika Guest (belum login), id akan menjadi 0.
        $wisatawanId = Auth::check() ? Auth::user()->id_wisatawan : 0;

        // 2. Definisikan Base Query (Rating, Harga, dan Status Bookmark)
        $baseQuery = TempatWisata::with(['fotoTempatWisatas', 'penilaians'])
            ->select('tempat_wisatas.*')
            
            // a. Hitung Rata-rata Penilaian (AVG) dan Jumlah Review (COUNT)
            ->leftJoin('penilaians', 'tempat_wisatas.id_tempat', '=', 'penilaians.id_tempat')
            ->selectRaw('AVG(penilaians.penilaian) as avg_rating, COUNT(penilaians.id_penilaian) as review_count')
            
            // b. Ambil Harga Termurah dari Paket Wisata (Kolom 'harga' di paket_wisatas)
            ->leftJoin('paket_wisatas', 'tempat_wisatas.id_tempat', '=', 'paket_wisatas.id_tempat')
            ->selectRaw('MIN(paket_wisatas.harga) as min_harga') 
            
            // c. Cek Status Bookmark (1 jika ada, 0 jika tidak)
            ->selectRaw('EXISTS(SELECT 1 FROM bookmarks WHERE id_tempat = tempat_wisatas.id_tempat AND id_wisatawan = ?) as is_bookmarked', [$wisatawanId])
            
            // d. Grouping
           ->groupBy(
               'tempat_wisatas.id_tempat', 
               'tempat_wisatas.id_ptw', 
               'tempat_wisatas.nama_tempat', 
               'tempat_wisatas.alamat_tempat', 
               'tempat_wisatas.jenis_tempat', 
               'tempat_wisatas.waktu_buka', 
               'tempat_wisatas.waktu_tutup', 
               'tempat_wisatas.deskripsi',
               'tempat_wisatas.created_at',
               'tempat_wisatas.updated_at'
            )
            
            // e. Urutkan
            ->orderByDesc('avg_rating'); 

        // 3. Destinasi Populer: Top 4
        $populerModels = (clone $baseQuery)
            ->take(4)
            ->get();

        // 4. Rekomendasi Destinasi: 4 lainnya secara Acak
        $rekomendasiModels = (clone $baseQuery)
            ->whereNotIn('tempat_wisatas.id_tempat', $populerModels->pluck('id_tempat')->toArray())
            ->inRandomOrder()
            ->take(4)
            ->get();

        // 5. Fungsi Helper untuk Memformat Data
        $formatData = function ($item) {
            $foto_utama = $item->fotoTempatWisatas->sortBy('urutan')->first();
            $alamat_parts = explode(',', $item->alamat_tempat); 
            
            return [
                'id_tempat' => $item->id_tempat, 
                'nama' => $item->nama_tempat,
                'lokasi' => trim(implode(', ', array_slice($alamat_parts, -2, 2))), // Lokasi singkat
                'deskripsi' => $item->deskripsi ? (strlen($item->deskripsi) > 100 ? substr($item->deskripsi, 0, 100) . '...' : $item->deskripsi) : 'Deskripsi belum tersedia.',
                'rating' => number_format($item->avg_rating ?? 0, 1),
                'reviews' => $item->review_count,
                'harga' => $item->min_harga ?? 0, 
                'foto' => $foto_utama ? $foto_utama->url_foto : 'default.jpg', 
                'is_bookmarked' => (bool)$item->is_bookmarked,
            ];
        };

        $populer = $populerModels->map($formatData);
        $rekomendasi = $rekomendasiModels->map($formatData);

        return view('home', compact('populer', 'rekomendasi'));
    }
}