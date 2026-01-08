<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wisatawan extends Model
{
    // Nama tabel HARUS 'wisatawan' sesuai database kamu
    protected $table = 'wisatawan'; 

    // Primary Key-nya HARUS 'id_wisatawan'
    protected $primaryKey = 'id_wisatawan'; 

    protected $fillable = [
        'nama', 
        'email', 
        'password', 
        'no_hp', 
        'status'
    ];

    // Sembunyikan password biar aman pas di-get
    protected $hidden = ['password'];
}