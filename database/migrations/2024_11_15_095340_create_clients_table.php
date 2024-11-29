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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('client_firstname');
            $table->string('client_lastname');
            $table->string('client_phoneno');
            $table->string('email');
            $table->string('client_address_one')->nullable();
            $table->string('client_address_two')->nullable();
            $table->string('client_postcode')->nullable();
            $table->string('client_state')->nullable();
            $table->string('client_area')->nullable();
            $table->integer('client_status')->default(0);
            $table->string('client_photo')->nullable();
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
