<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'Name' => $this->faker->name(),
            'Email' => $this->faker->unique()->safeEmail(),
            'PhoneNumber' => $this->faker->phoneNumber(),
            'Password' => Hash::make('password'), // Default password
            'Address' => $this->faker->address(),
            'Role' => $this->faker->randomElement(['Client', 'Photographer', 'Admin']),
        ];
    }
}
