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
		Schema::create('posts', function($table)
		{
			$table->increments('id');
			$table->string('title')->nullable();
			$table->string('location')->nullable();
			$table->string('timeline')->nullable();
			$table->integer('mission_id');
			$table->integer('saved_user_id')->nullable();
			$table->boolean('status')->default(3);
			$table->text('content');
			$table->text('keywords')->nullable();
			$table->text('participants')->nullable();
			$table->integer('lock_user_id')->nullable();
			$table->datetime('lock_date');
			$table->timestamps();
		});

		Schema::create('post_authors', function($table)
		{
			$table->increments('id');
			$table->integer('post_id');
			$table->integer('user_id');
			$table->integer('character_id');
		});

		Schema::create('post_locks', function($table)
		{
			$table->increments('id');
			$table->integer('post_id');
			$table->integer('user_id');
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
		Schema::drop('posts');
		Schema::drop('post_authors');
		Schema::drop('post_locks');
	}
}
