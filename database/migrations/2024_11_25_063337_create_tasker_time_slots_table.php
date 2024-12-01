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
        Schema::create('tasker_time_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slot_id')->references('id')->on('time_slots');
            $table->foreignId('tasker_id')->references('id')->on('taskers');
            $table->date('slot_date');
            $table->integer('slot_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasker_time_slots');
    }
};
