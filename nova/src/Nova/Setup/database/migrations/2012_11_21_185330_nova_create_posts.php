<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreatePosts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function($t)
		{
			$t->increments('id');
			$t->string('title')->nullable();
			$t->string('location')->nullable();
			$t->string('timeline')->nullable();
			$t->integer('mission_id');
			$t->integer('saved_user_id')->nullable();
			$t->boolean('status')->default(Status::ACTIVE);
			$t->text('content')->nullable();
			$t->text('keywords')->nullable();
			$t->timestamps();
		});

		Schema::create('post_authors', function($t)
		{
			$t->increments('id');
			$t->integer('post_id');
			$t->integer('user_id');
			$t->integer('character_id');
		});

		Schema::create('post_locks', function($t)
		{
			$t->increments('id');
			$t->integer('post_id');
			$t->integer('user_id');
			$t->timestamps();
		});

		Schema::create('post_participants', function($t)
		{
			$t->increments('id');
			$t->integer('post_id');
			$t->integer('user_id');
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