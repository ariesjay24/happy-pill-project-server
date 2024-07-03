<?php

namespace Database\Factories;

use App\Models\Photographer;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhotographerFactory extends Factory
{
    protected $model = Photographer::class;

    public function definition()
    {
        return [
            'FullName' => $this->faker->name(), // Corrected column name
            'Email' => $this->faker->unique()->safeEmail(),
            'PhoneNumber' => $this->faker->phoneNumber(),
            'Portfolio' => $this->faker->url(),
            'UserID' => \App\Models\User::factory() // Assuming each photographer is linked to a user
        ];
    }
}
