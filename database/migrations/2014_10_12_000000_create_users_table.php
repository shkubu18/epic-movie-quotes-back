<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('users', function (Blueprint $table) {
			$table->id();
			$table->string('username')->unique();
			$table->string('email')->unique();
			$table->string('email_verification_token')->unique()->nullable();
			$table->string('temporary_email')->nullable();
			$table->string('temporary_email_verification_token')->unique()->nullable();
			$table->timestamp('email_verified_at')->nullable();
			$table->string('password')->nullable();
			$table->string('profile_picture')->nullable();
			$table->string('google_id')->unique()->nullable();
			$table->rememberToken();
			$table->timestamps();

			$table->index('email_verification_token');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('users');
	}
};
