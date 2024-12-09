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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->date('booking_date');
            $table->text('booking_address');
            $table->time('booking_time_start')->nullable();
            $table->time('booking_time_end')->nullable();
            $table->integer('booking_status')->default(1);
            $table->text('booking_note')->nullable();
            $table->decimal('booking_rate', 8, 2); 
            $table->foreignId('client_id')->references('id')->on('clients');
            $table->foreignId('service_id')->references('id')->on('services');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
