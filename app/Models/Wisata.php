<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    // Sesuaikan: 'wisatas' atau 'wisata'? 
    protected $table = 'wisatas'; 

    protected $fillable = ['nama_wisata', 'pemilik', 'deskripsi', 'status'];
}