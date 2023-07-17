<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GenreMovie>
 */
class GenreMovieFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'genre_id' => fake()->unique()->numberBetween(1, 15),
			'movie_id' => fake()->numberBetween(1, 10),
		];
	}
}
