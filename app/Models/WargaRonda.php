<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <--- Perhatikan tambahan kata 'Eloquent' di sini
use Illuminate\Database\Eloquent\Model;

class WargaRonda extends Model
{
    use HasFactory;

    protected $table = 'warga_rondas';
    protected $fillable = ['nama', 'blok_rumah', 'status_aktif'];

    public function jadwalRonda()
    {
        return $this->hasMany(JadwalRonda::class, 'warga_id');
    }
}