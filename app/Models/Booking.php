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
        'booking_latitude',
        'booking_longitude',
        'booking_time_start',
        'booking_time_end',
        'booking_status',
        'booking_note',
        'booking_rate',
        'client_id',
        'service_id',

    ];
}
