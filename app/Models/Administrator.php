<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Administrator extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'admin_code',
        'admin_firstname',
        'admin_lastname',
        'admin_phoneno',
        'email',
        'admin_status',
        'password',
    ];

}
