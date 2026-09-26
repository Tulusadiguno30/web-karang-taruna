<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasMasuk extends Model
{
    use HasFactory;

    protected $table = 'kas_masuks';

    // TAMBAHKAN 'user_id' DI SINI:
    protected $fillable = [
        'tanggal', 
        'anggota_id', 
        'keterangan', 
        'nominal', 
        'bukti_nota', 
        'user_id'
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }
}