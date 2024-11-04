<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_code',
        'admin_firstname',
        'admin_lastname',
        'admin_phoneno',
        'email',
        'admin_status',
        'admin_password',
    ];

}
