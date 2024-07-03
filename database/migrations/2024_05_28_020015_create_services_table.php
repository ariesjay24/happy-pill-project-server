<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id('ServiceID');
            $table->string('Name');
            $table->text('Description');
            $table->decimal('Price', 8, 2);
            $table->boolean('isAddOn')->default(false); // New column to distinguish add-ons
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
