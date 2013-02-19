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
		Schema::create('personal_logs', function($t)
		{
			$t->increments('id');
			$t->string('title')->nullable();
			$t->integer('user_id');
			$t->integer('character_id');
			$t->text('content')->nullable();
			$t->boolean('status')->default(3);
			$t->text('keywords')->nullable();
			$t->timestamps();
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
