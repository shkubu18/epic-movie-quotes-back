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
			'quotes'          => $this->when($this->quotes->isNotEmpty(), $this->quotes),
			'picture'         => $this->picture,
			'release_date'    => $this->release_date,
			'genres'          => $this->when($include, $this->genres->pluck('name')->toArray()),
			'name'            => $this->getTranslation('name', app()->getLocale()),
			'director'        => $this->when($include, $this->getTranslation('director', app()->getLocale())),
			'description'     => $this->when($include, $this->getTranslation('description', app()->getLocale())),
			'user'            => [
				'username'        => $this->user->username,
				'profile_picture' => $this->when($this->user->profile_picture, $this->user->profile_picture),
			],
		];
	}
}
