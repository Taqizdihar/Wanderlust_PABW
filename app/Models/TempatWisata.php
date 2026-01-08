<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TempatWisata extends Model {
    use HasFactory;

    protected $table = 'tempat_wisata';

    protected $primaryKey = 'id_wisata'; 

    protected $fillable = [
        'id_ptw',
        'nama_wisata',
        'alamat_wisata',
        'kota',
        'jenis_wisata',
        'waktu_buka',
        'waktu_tutup',
        'deskripsi',
        'status_wisata',
        'catatan_revisi'
    ];

    public function pemilik() {
        return $this->belongsTo(PemilikTempatWisata::class, 'id_ptw');
    }

    public function tiketTempatWisata() {
        return $this->hasMany(TiketTempatWisata::class, 'id_wisata');
    }

    public function fotoTempatWisatas() {
        return $this->hasMany(FotoTempatWisata::class, 'id_tempat', 'id_tempat');
    }

    public function penilaian() {
        return $this->hasMany(Penilaian::class, 'id_wisata');
    }

    public function bookmark() {
        return $this->hasMany(Bookmark::class, 'id_wisata');
    }
}