<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FotoTempatWisata extends Model {
    use HasFactory;

    protected $table = 'foto_tempat_wisatas';

    protected $primaryKey = 'id_foto';

    protected $fillable = [
        'id_wisata',
        'foto_wisata',
        'urutan'
    ];

    public function tempatWisata() {
        return $this->belongsTo(TempatWisata::class, 'id_wisata');
    }
}

