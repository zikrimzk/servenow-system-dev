<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_rating',
        'review_description',
        'review_date_time',
        'review_imageOne',
        'review_imageTwo',
        'review_imageThree',
        'review_imageFour',
        'review_type',
        'booking_id'
     ];
}
