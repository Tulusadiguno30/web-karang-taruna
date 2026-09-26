<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi ke data iuran kas anggota
    public function contributions()
    {
        return $this->hasMany(MemberContribution::class);
    }
}