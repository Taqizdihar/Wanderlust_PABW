<?php

namespace App\Http\Controllers\Wisatawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon; // Diperlukan untuk perhitungan Usia
use Illuminate\Support\Facades\Storage; // Diperlukan untuk upload foto
use App\Models\User; // Diperlukan untuk Auth::login($freshUser)

class editProfilController extends Controller
{
    /**
     * Menampilkan halaman Edit Profil (Form) dengan data yang sudah ada.
     * Dipanggil oleh Route::get('/edit-profil', ... , 'show')
     */
    public function show() 
    {
        // 1. Mendapatkan data user yang sedang login
        $user = Auth::user();

        // 2. Mengambil data Wisatawan (detail profil) melalui relasi
        $wisatawan = $user->wisatawan; 
        
        // --- FIX: Hitung Usia dan siapkan variabel $usia (Integer) ---
        $usia = null;
         if ($wisatawan && $wisatawan->tanggal_lahir) {
         $birthDate = Carbon::parse($wisatawan->tanggal_lahir);
        // Menggunakan diffInYears() yang akan menghasilkan integer (bilangan bulat)
         $usia = $birthDate->diffInYears(Carbon::now()); // <--- PASTIKAN BARIS INI BENAR
    }
        // -----------------------------------------------------------

        // 3. Tampilkan view editProfil dan kirimkan data, termasuk $usia
        return view('editProfil', compact('user', 'wisatawan', 'usia')); 
    }

    /**
     * Menyimpan data yang diubah dari Form Edit Profil ke database.
     * Dipanggil oleh Route::post('/update-profil', ... , 'update')
     */
    public function update(Request $request)
    {
        // 1. Ambil User dan Wisatawan yang sedang login
        $user = Auth::user();
        $wisatawan = $user->wisatawan;

        // 2. Validasi Input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id_user . ',id_user', 
            'no_telepon' => 'nullable|string|max:15',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => ['nullable', Rule::in(['L', 'P'])], 
            'kota_asal' => 'nullable|string|max:255',
            'preferensi_wisata' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        // 3. Memulai Transaksi Database
        try {
            DB::beginTransaction();

            // --- Data untuk Tabel 'users' ---
            $dataToUpdateUser = [
                'nama' => $request->nama,
                'email' => $request->email,
            ];

            // --- Logika Upload Foto Profil BARU ---
            if ($request->hasFile('foto_profil')) {
                $image = $request->file('foto_profil');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                
                // Hapus foto profil lama jika ada
                if ($user->foto_profil && $user->foto_profil !== 'default.png' && Storage::disk('public')->exists('images/profiles/' . $user->foto_profil)) {
                    Storage::disk('public')->delete('images/profiles/' . $user->foto_profil);
                }
                
                // Simpan foto baru
                $image->storeAs('images/profiles', $imageName, 'public');
                $dataToUpdateUser['foto_profil'] = $imageName; // Tambahkan nama file baru ke data user
            }
            // ----------------------------------------
            
            // 4. Update Database
            $user->update($dataToUpdateUser); // Update data users

            // --- Data untuk Tabel 'wisatawan' ---
            if ($wisatawan) {
                $dataToUpdateWisatawan = [
                    'no_telepon' => $request->no_telepon,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin, 
                    'kota_asal' => $request->kota_asal,
                    'preferensi_wisata' => $request->preferensi_wisata,
                    'alamat' => $request->alamat,
                ];
                $wisatawan->update($dataToUpdateWisatawan); // Update data wisatawan
            }
            
            DB::commit();

            // 5. FIX KRITIS: Memuat ulang User ke dalam sesi agar foto profil baru muncul
            $freshUser = User::find($user->id_user); 
            Auth::login($freshUser); 

            // 6. Redirect dan Tampilkan Pesan Sukses
            return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();

            // 7. Redirect dan Tampilkan Pesan Error
            return redirect()->route('edit-profil')->with('error', 'Gagal memperbarui profil. Silakan coba lagi. Error: ' . $e->getMessage());
        }
    }
}