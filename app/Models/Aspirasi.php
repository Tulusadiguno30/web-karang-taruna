<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    use HasFactory;

    // Beritahu Laravel bahwa primary key-nya adalah aspirasi_id
    protected $primaryKey = 'aspirasi_id';

    // Daftarkan kolom-kolom sesuai dengan struktur tabelmu
    protected $fillable = [
        'nama_pengirim', 
        'kontak', 
        'pesan', 
        'status'
    ];
}