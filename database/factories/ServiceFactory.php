<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->sentence(),
            'price' => fake()->numberBetween(100, 500),
            'init_payment' => fake()->numberBetween(50, 250),
            'image' => fake()->imageUrl(400, 400, 'medical'),
            'time_slot' => '[{"duration":"08:00 AM - 08:40 AM","slot":null},{"duration":"08:40 AM - 09:20 AM","slot":null},{"duration":"09:20 AM - 10:00 AM","slot":null},{"duration":"10:00 AM - 10:40 AM","slot":null},{"duration":"10:40 AM - 11:20 AM","slot":null},{"duration":"11:20 AM - 12:00 PM","slot":null},{"duration":"12:00 PM - 01:00 PM","slot":"break"},{"duration":"01:00 PM - 01:40 PM","slot":null},{"duration":"01:40 PM - 02:20 PM","slot":null},{"duration":"02:20 PM - 03:00 PM","slot":null},{"duration":"03:00 PM - 03:40 PM","slot":null},{"duration":"03:40 PM - 04:20 PM","slot":null},{"duration":"04:20 PM - 05:00 PM","slot":null}]',
            'session_time' => fake()->randomElement(['40', '60'])
        ];
    }
}
