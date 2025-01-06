<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyStatement extends Model
{
    use HasFactory;

    protected $fillable =[
        'start_date',
        'end_date',
        'file_name',
        'statement_status',
        'total_earnings',
        'tasker_id',
    ];
}
