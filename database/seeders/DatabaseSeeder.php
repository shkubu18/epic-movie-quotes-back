<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\GenreMovie;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		User::factory(5)->create();
		Genre::factory(10)->create();
		Movie::factory(10)->create();
		GenreMovie::factory(15)->create();
		Quote::factory(15)->create();
		Comment::factory(20)->create();

		// \App\Models\User::factory()->create([
		//     'name' => 'Test User',
		//     'email' => 'test@example.com',
		// ]);
	}
}
