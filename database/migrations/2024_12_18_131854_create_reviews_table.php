<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id(); 
            $table->string('review_rating'); 
            $table->text('review_description')->nullable();
            $table->string('review_imageOne')->nullable();
            $table->string('review_imageTwo')->nullable();
            $table->string('review_imageThree')->nullable();
            $table->string('review_imageFour')->nullable();
            $table->integer('review_type')->default(1); // 1 - Normal 2 - Anonymous
            $table->integer('review_status')->default(1); // 0 - hide 1 - show 
            $table->datetime('review_date_time');
            $table->foreignId('booking_id')->references('id')->on('bookings');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
