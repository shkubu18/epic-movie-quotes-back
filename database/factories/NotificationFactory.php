<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'quote_id'   => fake()->numberBetween(1, 15),
			'receiver'   => fake()->numberBetween(1, 5),
			'sender'     => fake()->numberBetween(1, 5),
			'type'       => fake()->randomElement(['like', 'comment']),
			'read'       => fake()->boolean(70),
		];
	}
}
