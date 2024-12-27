<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewReply extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'reply_by',
        'reply_message',
        'reply_date_time',
        'review_id'
    ];
}
