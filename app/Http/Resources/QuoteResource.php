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
				'name'         => ['en' => $this->movie->getTranslation('name', 'en'), 'ka' => $this->movie->getTranslation('name', 'ka')],
				'release_date' => $this->movie->release_date,
			],
			'user'         => [
				'id'              => $this->movie->user->id,
				'name'            => $this->movie->user->username,
				'profile_picture' => $this->when($this->movie->user->profile_picture, $this->movie->user->profile_picture),
			],
			'comments'          => $this->when($this->comments->isNotEmpty(), CommentResource::collection($this->comments)),
			'total_likes'       => $this->when($this->likes->isNotEmpty(), $this->likes->count()),
			'total_comments'    => $this->when($this->comments->isNotEmpty(), $this->comments->count()),
		];
	}
}
