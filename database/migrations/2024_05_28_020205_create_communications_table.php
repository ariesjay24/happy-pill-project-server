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
        Schema::create('communications', function (Blueprint $table) {
            $table->id('CommunicationID');
            $table->unsignedBigInteger('UserID');
            $table->string('Type', 20); // Chat, Email, SMS
            $table->text('Content')->nullable();
            $table->timestamp('Timestamp');
            $table->string('MessengerLink')->nullable();
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
        Schema::dropIfExists('communications');
    }
};
