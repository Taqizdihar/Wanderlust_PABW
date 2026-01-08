<?php

namespace App\Http\Controllers\Wisatawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PencarianController extends Controller
{
    public function index(Request $request)
    {
        $kataKunci = $request->query('kataKunci', '');

        $dataTempatWisata = [
    
            ['tempatwisata_id' => 1, 'nama_lokasi' => 'Lembang', 'deskripsi' => 'Nikmati udara sejuk pegunungan dan kebun teh yang hijau di Bandung Utara.', 'sumir' => 'Wisata alam pegunungan yang menenangkan.', 'link_foto' => 'lembang.jpg'],
            ['tempatwisata_id' => 2, 'nama_lokasi' => 'Kawah Putih Ciwidey', 'deskripsi' => 'Danau vulkanik dengan air berwarna toska dan suasana magis di Ciwidey.', 'sumir' => 'Pemandangan eksotis yang cocok untuk fotografi.', 'link_foto' => 'kawahputih.jpg'],
            ['tempatwisata_id' => 3, 'nama_lokasi' => 'Orchid Forest Cikole', 'deskripsi' => 'Taman anggrek terbesar di Indonesia dengan suasana hutan pinus yang sejuk.', 'sumir' => 'Tempat favorit untuk healing dan foto estetik.', 'link_foto' => 'orchidforest.jpg'],
            ['tempatwisata_id' => 4, 'nama_lokasi' => 'Dusun Bambu', 'deskripsi' => 'Wisata keluarga dengan pemandangan alam, kuliner, dan spot foto cantik.', 'sumir' => 'Destinasi ramah keluarga di Bandung Barat.', 'link_foto' => 'dusunbambu.jpg'],

            ['tempatwisata_id' => 5, 'nama_lokasi' => 'Candi Borobudur', 'deskripsi' => 'Candi Buddha terbesar di dunia dan warisan budaya dunia UNESCO.', 'sumir' => 'Situs bersejarah penuh makna spiritual.', 'link_foto' => 'candi_borobudur.jpg'],
            ['tempatwisata_id' => 6, 'nama_lokasi' => 'Pantai Parangtritis', 'deskripsi' => 'Pantai terkenal di Yogyakarta dengan ombak besar dan pasir hitam yang khas.', 'sumir' => 'Ikon wisata laut selatan Yogyakarta.', 'link_foto' => 'pantai_parangtritis.jpg'],
            ['tempatwisata_id' => 7, 'nama_lokasi' => 'Tebing Breksi', 'deskripsi' => 'Destinasi wisata unik hasil tambang batu yang kini jadi tempat spot foto ikonik.', 'sumir' => 'Wisata alam dan budaya yang populer di Jogja.', 'link_foto' => 'tebing_breksi.jpg'],
            ['tempatwisata_id' => 8, 'nama_lokasi' => 'Malioboro', 'deskripsi' => 'Jalan legendaris di pusat kota Yogyakarta yang dipenuhi toko dan pedagang.', 'sumir' => 'Pusat belanja dan kuliner khas Jogja.', 'link_foto' => 'jalan_malioboro.jpg'],

            ['tempatwisata_id' => 9, 'nama_lokasi' => 'Tanah Lot', 'deskripsi' => 'Pura di atas batu karang dengan pemandangan matahari terbenam yang memukau.', 'sumir' => 'Spot sunset paling ikonik di Bali.', 'link_foto' => 'tanah_lot.jpg'],
            ['tempatwisata_id' => 10, 'nama_lokasi' => 'Ubud Monkey Forest', 'deskripsi' => 'Hutan alami dengan ratusan monyet dan nuansa spiritual khas Bali.', 'sumir' => 'Wisata alam sekaligus budaya di jantung Bali.', 'link_foto' => 'monkeyforest.jpg'],
            ['tempatwisata_id' => 11, 'nama_lokasi' => 'Pantai Kuta', 'deskripsi' => 'Pantai paling populer di Bali untuk menikmati sunset dan surfing.', 'sumir' => 'Surga bagi pencinta pantai dan ombak.', 'link_foto' => 'pantai_kuta.jpg'],
            ['tempatwisata_id' => 12, 'nama_lokasi' => 'Pura Ulun Danu Beratan', 'deskripsi' => 'Pura indah di tepi Danau Beratan Bedugul, Bali Utara.', 'sumir' => 'Pemandangan menenangkan dengan udara sejuk pegunungan.', 'link_foto' => 'ulundanu.jpg'],

            ['tempatwisata_id' => 13, 'nama_lokasi' => 'Gunung Bromo', 'deskripsi' => 'Gunung berapi aktif dengan pemandangan sunrise terbaik di Indonesia.', 'sumir' => 'Spot sunrise paling terkenal di Jawa Timur.', 'link_foto' => 'gunung_bromo.jpg'],
            ['tempatwisata_id' => 14, 'nama_lokasi' => 'Raja Ampat', 'deskripsi' => 'Kepulauan dengan keindahan bawah laut yang luar biasa.', 'sumir' => 'Surga snorkeling dan diving dunia.', 'link_foto' => 'raja_ampat.jpg'],
            ['tempatwisata_id' => 15, 'nama_lokasi' => 'Labuan Bajo', 'deskripsi' => 'Gerbang menuju Pulau Komodo dengan panorama laut biru nan jernih.', 'sumir' => 'Destinasi eksotis untuk pencinta laut.', 'link_foto' => 'labuan_bajo.jpg'],
            ['tempatwisata_id' => 16, 'nama_lokasi' => 'Lombok Mandalika', 'deskripsi' => 'Destinasi wisata baru dengan sirkuit internasional dan pantai indah.', 'sumir' => 'Wisata modern dengan nuansa tropis.', 'link_foto' => 'mandalika.jpg'],
        ];

        $hasilPencarian = array_filter($dataTempatWisata, function ($item) use ($kataKunci) {
            return stripos($item['nama_lokasi'], $kataKunci) !== false ||
                   stripos($item['deskripsi'], $kataKunci) !== false ||
                   stripos($item['sumir'], $kataKunci) !== false ||
                   stripos($item['link_foto'], $kataKunci) !== false;
        });

        return view('pencarian', [
            'kataKunci' => $kataKunci,
            'hasilPencarian' => $hasilPencarian
        ]);
    }
}