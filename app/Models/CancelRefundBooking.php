<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelRefundBooking extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'cr_date',
        'cr_status',
        'cr_reason',
        'cr_amount',
        'cr_bank_name',
        'cr_account_name',
        'cr_account_number',
        'cr_penalized',
        'booking_id',
    ];
}
