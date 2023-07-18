<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
	use HasFactory;

	protected $guarded = ['id'];

	public function receiverUser(): BelongsTo
	{
		return $this->belongsTo(User::class, 'receiver');
	}

	public function senderUser(): BelongsTo
	{
		return $this->belongsTo(User::class, 'sender');
	}
}
