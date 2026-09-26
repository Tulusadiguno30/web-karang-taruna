<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberContribution extends Model
{
    use HasFactory;

    protected $fillable = ['officer_id', 'month_period', 'amount', 'status', 'payment_date'];

    public function officer()
    {
        return $this->belongsTo(Officer::class);
    }
}