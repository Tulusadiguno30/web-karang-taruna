<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_surat', 
        'jenis_surat', 
        'judul_atau_nama', 
        'dicetak_oleh'
    ];
}