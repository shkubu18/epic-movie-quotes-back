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
		return [
			'id'              => $this->id,
			'quotes'          => $this->quotes,
			'picture'         => $this->picture,
			'release_date'    => $this->release_date,
			'genres'          => $this->when($request->path() !== 'api/movies', $this->genres->pluck('name')->toArray()),
			'name'            => ['en' => $this->getTranslation('name', 'en'), 'ka' => $this->getTranslation('name', 'ka')],
			'director'        => ['en' => $this->getTranslation('director', 'en'), 'ka' => $this->getTranslation('director', 'ka')],
			'description'     => ['en' => $this->getTranslation('description', 'en'), 'ka' => $this->getTranslation('description', 'ka')],
		];
	}
}
