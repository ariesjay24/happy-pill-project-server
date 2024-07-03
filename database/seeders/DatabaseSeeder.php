<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Service;
use App\Models\Photographer;
use App\Models\Booking;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed users
        User::factory()->count(10)->create();

        // Seed services
        Service::factory()->count(10)->create();

        // Seed photographers
        Photographer::factory()->count(10)->create();

        // Seed bookings
        Booking::factory()->count(10)->create();
    }
}
