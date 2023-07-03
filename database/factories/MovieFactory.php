<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		// Check if the directory exists and create it if it does not.
		if (!File::exists('public/storage/movies/pictures')) {
			File::makeDirectory('public/storage/movies/pictures', $mode = 0755, true, true);
		}

		$image = \Faker\Factory::create()->image('public/storage/movies/pictures');

		return [
			'user_id' => fake()->numberBetween(1, 5),
			'name'    => [
				'en' => \Faker\Factory::create('en_US')->realText(10),
				'ka' => \Faker\Factory::create('ka_GE')->realText(10),
			],
			'release_date'  => fake()->numberBetween(1900, 2024),
			'director'      => [
				'en' => \Faker\Factory::create('en_US')->name,
				'ka' => \Faker\Factory::create('ka_GE')->name,
			],
			'description'      => [
				'en' => \Faker\Factory::create('en_US')->paragraph,
				'ka' => \Faker\Factory::create('ka_GE')->paragraph(3, true),
			],
			'picture'       => 'storage/movies/pictures/' . basename($image),
		];
	}
}
