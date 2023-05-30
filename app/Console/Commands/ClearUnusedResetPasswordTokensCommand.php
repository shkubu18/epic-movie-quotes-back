<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ClearUnusedResetPasswordTokensCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'unused-reset-password-tokens:clear';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Clear unused reset password tokens';

	/**
	 * Execute the console command.
	 */
	public function handle()
	{
		$expirationTime = Carbon::now()->subMinutes(10);

		DB::table('password_reset_tokens')->where('created_at', '<=', $expirationTime)->delete();

		$this->info('Unused reset password tokens cleared successfully.');
	}
}
