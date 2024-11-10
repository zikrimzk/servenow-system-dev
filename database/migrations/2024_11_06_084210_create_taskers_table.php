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
            $table->string('tasker_bio')->nullable();
            $table->string('tasker_address_no')->nullable();
            $table->string('tasker_address_road')->nullable();
            $table->string('tasker_address_city')->nullable();
            $table->string('tasker_address_poscode')->nullable();
            $table->string('tasker_address_state')->nullable();
            $table->string('tasker_workingloc_state')->nullable();
            $table->string('tasker_workingloc_area')->nullable();
            $table->integer('tasker_rating')->nullable();
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
