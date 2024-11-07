<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Tasker extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'tasker_code',
        'tasker_firstname',
        'tasker_lastname',
        'tasker_phoneno',
        'email',
        'tasker_status',
        'password',
        'tasker_icno',
        'tasker_dob',
        'tasker_photo',
        'tasker_workingloc_state',
        'tasker_workingloc_area',
        'tasker_rating',
    ];
}
