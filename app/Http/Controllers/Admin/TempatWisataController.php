<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TempatWisataController extends Controller
{
    // punya ikaa gemaz imoeddd
    
    public function index(Request $request)
    {
        $data_wisata = [
            [
                'id' => 1,
                'nama' => 'Pantai Kuta',
                'lokasi' => 'Bali',
                'harga' => 25000,
                'status' => 'Pending'
            ],
            [
                'id' => 2,
                'nama' => 'Candi Borobudur',
                'lokasi' => 'Magelang',
                'harga' => 50000,
                'status' => 'Selesai'
            ],
            [
                'id' => 3,
                'nama' => 'Gunung Bromo',
                'lokasi' => 'Jawa Timur',
                'harga' => 30000,
                'status' => 'Pending'
            ]
        ];
        foreach ($data_wisata as &$wisata) {
            $statusKey = 'status_wisata.' . $wisata['id'];
            if ($request->session()->has($statusKey)) {
                $wisata['status'] = $request->session()->get($statusKey);
            }
        }
        return view('tempat_wisata', compact('data_wisata'));     
    }
}
