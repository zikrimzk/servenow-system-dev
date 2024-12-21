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
            $table->string('trans_refno')->unique();
            $table->integer('trans_status');
            $table->string('trans_reason');
            $table->string('trans_billcode');
            // $table->foreignId('booking_id')->references('id')->on('bookings');
            $table->string('trans_order_id');
            $table->string('trans_amount');
            $table->timestamp('trans_transaction_time');
            
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
