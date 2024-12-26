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
        Schema::create('taskers', function (Blueprint $table) {
            $table->id();
            $table->string('tasker_code')->unique();
            $table->string('tasker_firstname');
            $table->string('tasker_lastname');
            $table->string('tasker_phoneno');
            $table->string('email')->unique();
            $table->integer('tasker_status')->default(0);
            $table->string('password');
            $table->string('tasker_icno')->nullable();
            $table->date('tasker_dob')->nullable();
            $table->string('tasker_photo')->nullable();
            $table->text('tasker_bio')->nullable();
            $table->string('tasker_address_one')->nullable();
            $table->string('tasker_address_two')->nullable();
            $table->string('tasker_address_poscode')->nullable();
            $table->string('tasker_address_state')->nullable();
            $table->string('tasker_address_area')->nullable();
            $table->string('tasker_workingloc_state')->nullable();
            $table->string('tasker_workingloc_area')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->integer('working_radius')->nullable();
            $table->integer('tasker_working_status')->default(0);
            $table->integer('tasker_worktype')->nullable(); // part-time (1) OR full-time(2)
            $table->integer('tasker_rank')->nullable(); 
            $table->integer('tasker_rating')->nullable();
            $table->integer('tasker_selfrefund_count')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taskers');
    }
};
