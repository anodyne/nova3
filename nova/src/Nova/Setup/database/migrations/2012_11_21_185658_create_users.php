<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($t)
		{
			$t->increments('id');
		});

		Schema::create('user_suspended', function($t)
		{
			$t->increments('id');
			$t->integer('user_id')->unsigned();
			$t->integer('attempts');
			$t->boolean('suspended');
			$t->boolean('banned');
			$t->timestamp('last_attempt_at');
			$t->timestamp('suspended_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
		Schema::drop('user_suspended');
	}

}