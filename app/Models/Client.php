<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Client extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'client_firstname',
        'client_lastname',
        'client_phoneno',
        'email',
        'client_address_one',
        'client_address_two',
        'client_poscode',
        'client_state',
        'client_city',
        'client_status',
        'client_photo',
        'password',
    ];
}
