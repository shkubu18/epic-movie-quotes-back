<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('notifications', function (Blueprint $table) {
			$table->id();
			$table->foreignId('quote_id')->references('id')->on('quotes');
			$table->foreignId('receiver')->constrained()->cascadeOnDelete()->references('id')->on('users');
			$table->foreignId('sender')->constrained()->cascadeOnDelete()->references('id')->on('users');
			$table->string('type');
			$table->boolean('read')->default(false);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('notifications');
	}
};
