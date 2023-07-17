<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Genre>
 */
class GenreFactory extends Factory
{
	/**
	 * The available genre names.
	 *
	 * @var array
	 */
	protected $genres = [
		'Action',
		'Comedy',
		'Drama',
		'Horror',
		'Romance',
		'Thriller',
		'Sci-Fi',
		'Fantasy',
		'Mystery',
		'Adventure',
	];

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		return [
			'name' => $this->uniqueGenreName(),
		];
	}

	protected function uniqueGenreName(): string
	{
		$genre = $this->faker->randomElement($this->genres);
		$this->removeGenreName($genre);

		return $genre;
	}

	protected function removeGenreName($name): void
	{
		$this->genres = array_diff($this->genres, [$name]);
	}
}
