<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

// Ganti dari id_user menjadi id
protected $primaryKey = 'id';
protected $fillable = [
    'name',
    'email',
    'password',
    'bio', // Foto dihapus
];
    protected $hidden = [
        'password',
    ];

    public function administrator() {
        return $this->hasOne(Administrator::class, 'id_user');
    }

    public function wisatawan(){
        return $this->hasOne(Wisatawan::class, 'id_user');
    }

    public function pemilikTempatWisata() {
        return $this->hasOne(PemilikTempatWisata::class, 'id_user');
    }
}

