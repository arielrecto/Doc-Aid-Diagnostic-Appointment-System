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
            'time_slot' =>'[{"duration":"8:00AM - 9:00AM","slot":"1"},{"duration":"9:00AM - 10:00AM","slot":"2"},{"duration":"10:00AM - 11:00AM","slot":"3"},{"duration":"11:00AM  - 12:00PM","slot":"4"},{"duration":"12:00PM  - 1:00PM","slot":"break"},{"duration":"1:00PM  - 2:00PM","slot":"5"},{"duration":"2:00PM  - 3:00PM","slot":"6"},{"duration":"3:00PM  - 4:00PM","slot":"6"},{"duration":"4:00PM  - 5:00PM","slot":"1"}]'
        ];
    }
}
