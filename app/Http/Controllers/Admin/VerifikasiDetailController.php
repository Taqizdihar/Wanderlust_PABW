<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use function PHPUnit\Framework\returnSelf;

class VerifikasiDetailController extends Controller
{
    public function showDetail($id)
    {
        $data_wisata = [
            'id' => $id,
            'nama' => $id == 1 ? 'Pantai Kuta' : ($id == 2 ? 'Candi Borobudur' : 'Gunung Bromo'),
            'lokasi' => $id == 1 ? 'Badung, Bali' : ($id == 2 ? 'Magelang, Jawa Tengah' : 'Probolinggo, Jawa Timur'),
            'deskripsi' => 'Deskripsi lengkap tentang destinasi wisata ini, mencakup keunikan, fasilitas, dan sejarah singkatnya.',
            'harga' => $id == 1 ? 25000 : ($id == 2 ? 50000 : 30000),
            'status' => $id == 2 ? 'Selesai' : 'Pending', 
            'pemilik' => 'Pengelola ID ' . $id,
            'dokumen_izin' => 'SK Pariwisata No. ' . $id . '/2025',
            'tanggal_input' => date('d M Y H:i'),
        ];
        $statusKey = 'status_wisata.' . $id;
        if (session()->has($statusKey)) {
             $data_wisata['status'] = session()->get($statusKey);
        }

        return view('verifikasi_detail', compact('data_wisata'));
    }
    public function updateStatus(Request $request, $id)
    {
$newStatus = $request->input('status');
        $statusKey = 'status_wisata.' . $id;
 $request->session()->put($statusKey, $newStatus); 
        return redirect()->route('tempat-sesssionwisata');
    }
}






