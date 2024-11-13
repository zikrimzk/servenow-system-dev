<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable =[
        'service_rate',
        'service_rate_type',
        'service_desc',
        'service_status',
        'service_type_id',
        'tasker_id',
    ];
}
