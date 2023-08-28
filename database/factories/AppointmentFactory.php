<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient' => fake()->name(),
            'date' => fake()->dateTimeBetween('now', '1 year')->format('Y-m-d'),
            'time' => fake()->time() . ' - ' . fake()->time(),
            'type' => fake()->randomElement(['online', 'walk in']),
            'service_id' => fake()->numberBetween(1, Service::count()),
            'receipt_image' => fake()->imageUrl(500, 500, 'receipt'),
            'user_id' => 1,
            'status' => fake()->randomElement(['pending', 'approved']),
            'receipt_amount' => fake()->numberBetween(100, 1000),
            'balance' => fake()->numberBetween(100, 500),
            'total' => fake()->numberBetween(100, 1000)
        ];
    }
}
