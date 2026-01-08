<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wisata extends Model {
    protected $table = 'tempat_wisatas'; // Sesuaikan dengan nama tabel di phpMyAdmin kamu
    protected $primaryKey = 'id_tempat'; // WAJIB ADA INI biar gak error find($id)

    protected $fillable = [
        'nama_tempat', 
        'alamat_tempat', 
        'deskripsi', 
        'status'
    ];
}