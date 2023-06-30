<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

	public static function scopeSearch(Builder $query, ?string $search): void
	{
		$query->where('name->en', 'like', '%' . $search . '%')
			->orWhere('name->ka', 'like', '%' . $search . '%');
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function genres(): BelongsToMany
	{
		return $this->belongsToMany(Genre::class, 'movie_genres', 'movie_id', 'genre_id');
	}

	public function quotes(): HasMany
	{
		return $this->hasMany(Quote::class);
	}
}
