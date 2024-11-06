<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasker extends Model
{
    use HasFactory;

    protected $fillable = [
        'tasker_code',
        'tasker_firstname',
        'tasker_lastname',
        'tasker_phoneno',
        'tasker_email',
        'tasker_password',
        'tasker_icno',
        'tasker_dob',
        'tasker_photo',
        'tasker_workingloc_state',
        'tasker_workingloc_area',
        'tasker_rating',
    ];
}
