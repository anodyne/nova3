<?php

use Illuminate\Database\Migrations\Migration;

class CreatePersonalLogs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('personal_logs', function($table)
		{
			$table->increments('id');
			$table->string('title')->nullable();
			$table->integer('user_id');
			$table->integer('character_id');
			$table->text('content')->nullable();
			$table->boolean('status')->default(3);
			$table->text('keywords')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('personal_logs');
	}
}
