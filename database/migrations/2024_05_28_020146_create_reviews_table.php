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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('ReviewID');
            $table->unsignedBigInteger('UserID');
            $table->unsignedBigInteger('ServiceID');
            $table->integer('Rating');
            $table->text('Comment')->nullable();
            $table->date('ReviewDate');
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('UserID')->references('UserID')->on('users')->onDelete('cascade');
            $table->foreign('ServiceID')->references('ServiceID')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
