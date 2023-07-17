<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Movie extends Model
{
	use HasFactory, HasTranslations;

	protected $guarded = ['id'];

	public $translatable = ['name', 'director', 'description'];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function genres(): BelongsToMany
	{
		return $this->belongsToMany(Genre::class, 'genre_movies', 'movie_id', 'genre_id');
	}

	public function quotes(): HasMany
	{
		return $this->hasMany(Quote::class);
	}
}
