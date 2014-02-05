<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NovaCreateUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $t)
		{
			$t->increments('id');
			$t->integer('status')->default(Status::PENDING);
			$t->string('name');
			$t->string('email')->unique();
			$t->string('password');
			$t->integer('character_id')->unsigned()->nullable();
			$t->string('reset_password_hash')->nullable();
			$t->string('activation_hash')->nullable();
			$t->text('persistence_codes')->nullable();
			$t->string('ip_address');
			$t->datetime('leave_date');
			$t->datetime('last_post');
			$t->datetime('last_login');
			$t->datetime('activated_at');
			$t->timestamps();
		});

		Schema::create('users_loas', function(Blueprint $t)
		{
			$t->increments('id');
			$t->integer('user_id')->unsigned();
			$t->date('start_date');
			$t->date('end_date')->nullable();
			$t->string('duration');
			$t->text('reason')->nullable();
			$t->string('type')->default('loa');
			$t->timestamps();
		});

		Schema::create('users_preferences', function(Blueprint $t)
		{
			$t->bigIncrements('id');
			$t->integer('user_id')->unsigned();
			$t->string('key');
			$t->text('value')->nullable();
		});

		Schema::create('users_roles', function(Blueprint $t)
		{
			$t->bigIncrements('id');
			$t->integer('user_id')->unsigned();
			$t->integer('role_id')->unsigned();
		});

		Schema::create('users_suspended', function(Blueprint $t)
		{
			$t->increments('id');
			$t->integer('user_id')->unsigned();
			$t->string('ip_address')->nullable();
			$t->integer('attempts')->default(0);
			$t->boolean('suspended')->default(0);
			$t->boolean('banned')->default(0);
			$t->timestamp('last_attempt_at')->nullable();
			$t->timestamp('suspended_at')->nullable();
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