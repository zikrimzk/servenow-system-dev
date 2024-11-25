<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskerTimeSlot extends Model
{
    use HasFactory;
    protected $fillable = [
        'tasker_id',
        'slot_id',
        'slot_day',
        'slot_status'
    ];
}
