<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_date',
        'booking_address',
        'booking_time',
        'booking_status',
        'booking_note',
        'client_id',
        'service_id',

    ];
}
