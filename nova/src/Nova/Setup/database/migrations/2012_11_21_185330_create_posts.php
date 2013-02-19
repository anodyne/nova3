<?php

use Illuminate\Database\Migrations\Migration;

class CreatePosts extends Migration {

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
			$t->boolean('status')->default(3);
			$t->text('content');
			$t->text('keywords')->nullable();
			$t->text('participants')->nullable();
			$t->integer('lock_user_id')->nullable();
			$t->datetime('lock_date');
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
	}
}
