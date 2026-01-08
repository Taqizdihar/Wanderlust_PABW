<?php

namespace App\Http\Controllers\Wisatawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    // Fungsi untuk AJAX: Menambah atau menghapus bookmark
    public function toggle($idTempat)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        
        $wisatawanId = Auth::user()->id_wisatawan;
        
        $bookmark = Bookmark::where('id_wisatawan', $wisatawanId)
                            ->where('id_tempat', $idTempat)
                            ->first();

        if ($bookmark) {
            $bookmark->delete();
            $action = 'removed';
            $message = 'Destinasi dihapus dari favorit.';
        } else {
            Bookmark::create([
                'id_wisatawan' => $wisatawanId,
                'id_tempat' => $idTempat,
                // Kolom lain (tanggal_simpan) diisi otomatis
            ]);
            $action = 'added';
            $message = 'Destinasi ditambahkan ke favorit.';
        }

        return response()->json([
            'success' => true,
            'action' => $action,
            'message' => $message
        ]);
    }
    
    // Fungsi untuk menampilkan halaman daftar favorit
    public function index()
    {
        $bookmarks = Auth::user()->bookmarks()->with('tempatWisata')->get();
        return view('favorit', compact('bookmarks'));
    }
}