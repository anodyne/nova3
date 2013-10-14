<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NovaCreatePosts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $t)
		{
			$t->bigIncrements('id');
			$t->string('title')->nullable();
			$t->string('location')->nullable();
			$t->string('timeline')->nullable();
			$t->integer('mission_id')->unsigned();
			$t->integer('saved_user_id')->unsigned()->nullable();
			$t->boolean('status')->default(Status::ACTIVE);
			$t->text('content')->nullable();
			$t->text('keywords')->nullable();
			$t->timestamps();
		});

		Schema::create('post_authors', function(Blueprint $t)
		{
			$t->bigIncrements('id');
			$t->integer('post_id')->unsigned();
			$t->integer('user_id')->unsigned();
			$t->integer('character_id')->unsigned();
		});

		Schema::create('post_locks', function(Blueprint $t)
		{
			$t->increments('id');
			$t->integer('post_id')->unsigned();
			$t->integer('user_id')->unsigned();
			$t->timestamps();
		});

		Schema::create('post_participants', function(Blueprint $t)
		{
			$t->increments('id');
			$t->integer('post_id')->unsigned();
			$t->integer('user_id')->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts');
		Schema::drop('post_authors');
		Schema::drop('post_locks');
		Schema::drop('post_participants');
	}

}