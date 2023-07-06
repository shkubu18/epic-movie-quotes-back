<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		$include = $request->path() !== 'api/movies/search' && $request->path() !== 'api/movies';

		return [
			'id'              => $this->id,
			'quotes'          => $this->when($this->quotes->isNotEmpty(), QuoteResource::collection($this->quotes)),
			'picture'         => $this->picture,
			'release_date'    => $this->release_date,
			'genres'          => $this->when($include, GenreResource::collection($this->genres)),
			'name'            => ['en' => $this->getTranslation('name', 'en'), 'ka' => $this->getTranslation('name', 'ka')],
			'director'        => $this->when($include, ['en' => $this->getTranslation('director', 'en'), 'ka' => $this->getTranslation('director', 'ka')], ),
			'description'     => $this->when($include, ['en' => $this->getTranslation('description', 'en'), 'ka' => $this->getTranslation('description', 'ka')], ),
			'user'            => [
				'username'        => $this->user->username,
				'profile_picture' => $this->when($this->user->profile_picture, $this->user->profile_picture),
			],
		];
	}
}
