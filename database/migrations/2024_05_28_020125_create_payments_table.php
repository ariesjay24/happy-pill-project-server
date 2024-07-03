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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('PaymentID');
            $table->unsignedBigInteger('BookingID');
            $table->unsignedBigInteger('UserID');
            $table->decimal('Amount', 10, 2);
            $table->date('PaymentDate');
            $table->string('PaymentMethod', 20)->default('GCash');
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('BookingID')->references('BookingID')->on('bookings')->onDelete('cascade');
            $table->foreign('UserID')->references('UserID')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
