<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wisata extends Model {
    // Paksa Laravel menggunakan nama tabel yang ada di database kamu
    protected $table = 'tempat_wisatas'; 
    
    protected $primaryKey = 'id_tempat'; // Sesuaikan dengan PK di database kamu

    protected $fillable = [
        'nama_tempat', 
        'alamat_tempat', 
        'deskripsi', 
        'status'
    ];
}