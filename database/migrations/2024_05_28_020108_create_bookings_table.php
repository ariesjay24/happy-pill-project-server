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
            $table->json('AddOns')->nullable(); // New field for add-ons
            $table->decimal('Price', 8, 2)->default(0); // New field for price
            $table->enum('Status', ['Pending', 'Confirmed', 'Cancelled']);
            $table->string('payment_status')->default('Unpaid'); // New field for payment status
            $table->timestamps();

            $table->foreign('UserID')->references('UserID')->on('users')->onDelete('cascade');
            $table->foreign('ServiceID')->references('ServiceID')->on('services')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
