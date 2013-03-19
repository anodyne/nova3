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
			$t->integer('status')->default(Status::PENDING);
			$t->string('name');
			$t->string('email')->unique();
			$t->string('password');
			$t->integer('character_id')->nullable();
			$t->integer('role_id')->default(AccessRole::USER);
			$t->string('reset_password_hash')->nullable();
			$t->string('activation_hash')->nullable();
			$t->string('persist_hash')->nullable();
			$t->string('ip_address');
			$t->datetime('leave_date');
			$t->datetime('last_post');
			$t->datetime('last_login');
			$t->timestamps();
		});

		Schema::create('user_loas', function($t)
		{
			$t->increments('id')->unsigned();
			$t->integer('user_id');
			$t->date('start_date');
			$t->date('end_date')->nullable();
			$t->string('duration');
			$t->text('reason')->nullable();
			$t->string('type')->default('loa');
			$t->timestamps();
		});

		Schema::create('user_preferences', function($t)
		{
			$t->increments('id')->unsigned();
			$t->integer('user_id');
			$t->string('key');
			$t->text('value')->nullable();
		});

		Schema::create('user_suspended', function($t)
		{
			$t->increments('id');
			$t->integer('user_id');
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
		Schema::drop('user_loas');
		Schema::drop('user_preferences');
		Schema::drop('user_suspended');
	}

}