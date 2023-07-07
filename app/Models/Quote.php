<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Quote extends Model
{
	use HasFactory, HasTranslations;

	protected $guarded = ['id'];

	public $translatable = ['name'];

	public static function scopeSearch(Builder $query, string $search): void
	{
		if (Str::startsWith($search, '#')) {
			$searchedQuote = Str::substr($search, 1);

			$query->where('name->en', 'like', '%' . $searchedQuote . '%')
				->orWhere('name->ka', 'like', '%' . $searchedQuote . '%');
		} elseif (Str::startsWith($search, '@')) {
			$searchedMovie = Str::substr($search, 1);

			$query->whereHas('movie', function (Builder $query) use ($searchedMovie) {
				$query->where('name->en', 'like', '%' . $searchedMovie . '%')
					->orWhere('name->ka', 'like', '%' . $searchedMovie . '%');
			});
		}
	}

	public function movie(): BelongsTo
	{
		return $this->belongsTo(Movie::class);
	}

	public function comments(): HasMany
	{
		return $this->hasMany(Comment::class);
	}

	public function likes(): HasMany
	{
		return $this->hasMany(Like::class);
	}
}
