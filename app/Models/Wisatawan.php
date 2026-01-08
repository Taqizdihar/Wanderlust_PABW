<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wisatawan extends Model
{
    protected $table = 'wisatawan'; // Sesuai phpMyAdmin kamu
    protected $primaryKey = 'id_wisatawan'; // Sesuai phpMyAdmin kamu

    protected $fillable = [
        'nama', 
        'email', 
        'password', 
        'no_hp', 
        'status'
    ];
}