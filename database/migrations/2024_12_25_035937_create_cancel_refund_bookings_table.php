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
        Schema::create('cancel_refund_bookings', function (Blueprint $table) {
            $table->id();
            $table->date('cr_date');
            $table->integer('cr_status')->default(1);
            $table->text('cr_reason')->nullable();
            $table->decimal('cr_amount', 8, 2); 
            $table->string('cr_bank_name');
            $table->string('cr_account_name');
            $table->string('cr_account_number');
            $table->foreignId('booking_id')->references('id')->on('bookings');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancel_refund_bookings');
    }
};
