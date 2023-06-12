<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'       => $this->id,
			'name'     => ['en' => $this->getTranslation('name', 'en'), 'ka' => $this->getTranslation('name', 'ka')],
			'picture'  => $this->picture,
			'movie'    => [
				'name'         => $this->movie->name,
				'release_date' => $this->movie->release_date,
			],
			'user'         => [
				'name'    => $this->movie->user->username,
				'picture' => $this->movie->user->profile_picture,
			],
			'comments'       => $this->when($this->comments->isNotEmpty(), CommentResource::collection($this->comments)),
			'total_likes'    => $this->when($this->likes->isNotEmpty(), $this->likes->count()),
		];
	}
}
