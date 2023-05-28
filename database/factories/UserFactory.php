<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		// Check if the directory exists and create it if it does not.
		if (!File::exists('public/storage/users/pictures')) {
			File::makeDirectory('public/storage/users/pictures', $mode = 0755, true, true);
		}

		$image = \Faker\Factory::create()->image('public/storage/users/pictures');

		return [
			'username'                 => fake()->name(),
			'email'                    => fake()->unique()->safeEmail(),
			'email_verification_token' => Str::uuid()->toString(),
			'email_verified_at'        => now(),
			'password'                 => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
			'profile_picture'          => 'pictures/' . basename($image),
			'remember_token'           => Str::random(10),
		];
	}

	/**
	 * Indicate that the model's email address should be unverified.
	 */
	public function unverified(): static
	{
		return $this->state(fn (array $attributes) => [
			'email_verified_at' => null,
		]);
	}
}
