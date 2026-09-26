<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashTransaction extends Model
{
    protected $fillable = ['type', 'title', 'amount', 'category', 'description', 'receipt_image', 'transaction_date'];
}