<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		// Check if the directory exists and create it if it does not.
		if (!File::exists('public/storage/quotes/pictures')) {
			File::makeDirectory('public/storage/quotes/pictures', $mode = 0755, true, true);
		}

		$image = \Faker\Factory::create()->image('public/storage/quotes/pictures');

		return [
			'name' => [
				'en' => \Faker\Factory::create('en_US')->realText(30),
				'ka' => \Faker\Factory::create('ka_GE')->realText(30),
			],
			'movie_id'      => fake()->numberBetween(1, 10),
			'picture'       => 'storage/quotes/pictures/' . basename($image),
		];
	}
}
