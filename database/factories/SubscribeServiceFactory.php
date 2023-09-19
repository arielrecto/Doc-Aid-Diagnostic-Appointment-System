<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SubscribeServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'appointment_id' => fake()->numberBetween(1, Appointment::count()),
            'service_id' => fake()->numberBetween(1, Service::count()),
            'start_time' => fake()->time('H:i'),
            'end_time' => fake()->time('H:i')
        ];
    }
}
