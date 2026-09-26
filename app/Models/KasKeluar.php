<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasKeluar extends Model
{
    use HasFactory;

    protected $table = 'kas_keluars';

    protected $fillable = [
        'tanggal',
        'keterangan',
        'nominal',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}