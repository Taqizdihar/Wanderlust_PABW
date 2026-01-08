<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    // Ini rahasianya beb, biar dia nembak ke tabel teman kelompokmu
    protected $table = 'tempat_wisatas'; 

    protected $fillable = [
        'nama_wisata', 
        'pemilik', 
        'deskripsi', 
        'status'
    ];
}