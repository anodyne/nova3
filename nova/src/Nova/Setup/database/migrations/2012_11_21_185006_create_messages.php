<?php

use Illuminate\Database\Migrations\Migration;

class CreateMessages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function($t)
		{
			$t->increments('id')->unsigned();
			$t->integer('user_id');
			$t->integer('character_id');
			$t->string('subject');
			$t->text('content');
			$t->boolean('status')->default(3);
			$t->datetime('created_at');
		});

		Schema::create('message_recipients', function($t)
		{
			$t->increments('id')->unsigned();
			$t->integer('message_id');
			$t->integer('user_id');
			$t->integer('character_id');
			$t->boolean('read')->default(0);
			$t->boolean('status')->default(3);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('messages');
		Schema::drop('message_recipients');
	}
}
