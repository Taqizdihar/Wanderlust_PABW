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
}