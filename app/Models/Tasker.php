<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;


class Tasker extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;

    protected $guard = "tasker";


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
        'tasker_address_one',
        'tasker_address_two',
        'tasker_address_poscode',
        'tasker_address_state',
        'tasker_address_area',
        'tasker_workingloc_state',
        'tasker_workingloc_area',
        'tasker_working_status',
        'tasker_worktype',
        'tasker_rank',
        'tasker_rating',
        'latitude',
        'longitude',
        'working_radius',
    ];
}
