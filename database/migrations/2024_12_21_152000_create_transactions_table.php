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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); 
            $table->string('trans_refno')->unique()->nullable();
            $table->integer('trans_status')->nullable();
            $table->string('trans_reason')->nullable();
            $table->string('trans_billcode')->nullable();
            $table->string('booking_order_id');
            $table->foreign('booking_order_id')->references('booking_order_id')->on('bookings');
            $table->string('trans_amount')->nullable();
            $table->timestamp('trans_transaction_time')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
