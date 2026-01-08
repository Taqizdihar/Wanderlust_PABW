<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
protected $table = 'tempat_wisatas'; // Sesuaikan nama tabel DB temanmu
protected $fillable = ['nama_wisata', 'pemilik', 'deskripsi', 'status'];
}