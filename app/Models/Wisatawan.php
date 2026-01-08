<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wisatawan extends Model
{
    // Jika di database barumu namanya 'wisatawans', ganti ini ya beb!
    protected $table = 'wisatawan'; 

    protected $fillable = ['nama', 'email', 'status'];
}