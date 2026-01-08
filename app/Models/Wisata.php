<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    protected $table = 'tempat_wisatas';
    protected $primaryKey = 'id_tempat';

    // WAJIB GANTI INI: Tambahkan kolom yang benar-benar ada di DB temanmu
    protected $fillable = [
        'nama_tempat', 
        'alamat_tempat', // Pastikan ini ada biar gak diblokir Laravel
        'deskripsi', 
        'status'
    ];
}