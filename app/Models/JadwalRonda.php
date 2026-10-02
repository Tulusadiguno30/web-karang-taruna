<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalRonda extends Model
{
    use HasFactory;

    protected $fillable = ['periode', 'tanggal_ronda', 'warga_id'];

    public function warga()
    {
        return $this->belongsTo(WargaRonda::class, 'warga_id');
    }
}