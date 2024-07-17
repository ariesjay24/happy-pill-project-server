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
        Schema::create('photographers', function (Blueprint $table) {
            $table->id('PhotographerID');
            $table->unsignedBigInteger('UserID'); 
            $table->string('FullName'); 
            $table->string('Email')->unique();
            $table->string('PhoneNumber');
            $table->string('Portfolio');
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('UserID')->references('UserID')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photographers');
    }
};
