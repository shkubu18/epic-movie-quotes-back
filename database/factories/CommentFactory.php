<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'user_id'  => fake()->numberBetween(1, 5),
			'body'     => fake()->paragraph,
			'quote_id' => fake()->numberBetween(1, 10),
		];
	}
}
