<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use App\Models\Service;
use App\Models\Photographer;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition()
    {
        return [
            'UserID' => User::factory(),
            'ServiceID' => Service::factory(),
            'PhotographerID' => Photographer::factory(),
            'BookingDate' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'Location' => $this->faker->address(),
        ];
    }
}
