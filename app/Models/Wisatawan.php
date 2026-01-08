<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wisatawan extends Model
{
    protected $table = 'wisatawan'; // Nama tabel kamu
    protected $primaryKey = 'id_wisatawan'; // Kasih tahu Laravel kalau PK kamu id_wisatawan

    protected $fillable = [
        'nama', 
        'email', 
        'password', 
        'no_hp', 
        'status'
    ];
    // Tambahkan fungsi ini beb!
public function updateStatus(Request $request, $id) {
    // Laravel bakal nyari berdasarkan 'id_wisatawan' karena sudah di-set di Model
    $user = Wisatawan::find($id);

    if (!$user) {
        return response()->json(['message' => 'User tidak ditemukan'], 404);
    }

    $user->update([
        'status' => $request->status ?? $user->status
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Status wisatawan berhasil diubah!',
        'data'    => $user
    ], 200);
}
}