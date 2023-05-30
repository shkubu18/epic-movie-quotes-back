<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
	use Queueable, SerializesModels;

	public function __construct(public string $verificationUrl, public string $username)
	{
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->view('emails.email-verification')
			->subject('Please verify your email address');
	}
}
