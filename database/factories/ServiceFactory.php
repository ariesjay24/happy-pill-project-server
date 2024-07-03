<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\Photographer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition()
    {
        return [
            'Name' => $this->faker->sentence(3),
            'Description' => $this->faker->paragraph(),
            'Price' => $this->faker->randomFloat(2, 50, 1000),
            'PhotographerID' => Photographer::factory(),
        ];
    }
}
