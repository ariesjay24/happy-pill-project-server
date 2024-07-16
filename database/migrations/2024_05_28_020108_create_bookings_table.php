<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('BookingID');
            $table->unsignedBigInteger('UserID');
            $table->unsignedBigInteger('ServiceID');
            $table->date('BookingDate');
            $table->time('BookingTime')->nullable();
            $table->string('Location');
            $table->json('AddOns')->nullable(); // Field for add-ons
            $table->decimal('Price', 8, 2)->default(0); // Field for price
            $table->enum('Status', ['Pending', 'Confirmed', 'Cancelled']);
            $table->string('payment_status')->default('Unpaid'); // Field for payment status
            $table->string('PaymentID')->nullable(); // New field for payment ID
            $table->timestamps();

            $table->foreign('UserID')->references('UserID')->on('users')->onDelete('cascade');
            $table->foreign('ServiceID')->references('ServiceID')->on('services')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
