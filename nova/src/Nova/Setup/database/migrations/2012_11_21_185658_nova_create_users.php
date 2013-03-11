<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateUsers extends Migration {

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
			$t->integer('status');
			$t->string('name');
			$t->string('email')->unique();
			$t->string('password');
			$t->integer('character_id');
			$t->integer('role_id');
			$t->string('reset_password_hash')->nullable();
			$t->string('activation_hash')->nullable();
			$t->string('persist_hash')->nullable();
			$t->string('ip_address');
			$t->datetime('leave_date');
			$t->datetime('last_post');
			$t->datetime('last_login');
			$t->timestamps();
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