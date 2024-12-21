<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'trans_refno' ,
        'trans_status' ,
        'trans_reason',
        'trans_billcode',
        'trans_order_id',
        'trans_amount',
        'trans_transaction_time',
    ];
}
