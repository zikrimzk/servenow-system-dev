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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->double('service_rate');
            $table->string('service_rate_type');
            $table->integer('service_status')->default(0);
            $table->foreignId('service_type_id')->references('id')->on('service_types');
            $table->foreignId('tasker_id')->references('id')->on('taskers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
