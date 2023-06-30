<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'                  => $this->id,
			'username'            => $this->username,
			'email'               => $this->email,
			'profile_picture'     => $this->when($this->profile_picture, $this->profile_picture),
			'google_id'           => $this->when($this->google_id, $this->google_id),
		];
	}
}
