<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proker extends Model
{
    use HasFactory;

    protected $table = 'prokers';
    protected $primaryKey = 'proker_id'; // Kunci utamanya proker_id sesuai database
    protected $guarded = [];
}
