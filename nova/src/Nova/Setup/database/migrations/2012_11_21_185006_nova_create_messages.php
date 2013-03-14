<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateMessages extends Migration {

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
			$t->boolean('status')->default(Status::ACTIVE);
			$t->timestamps();
		});

		Schema::create('message_recipients', function($t)
		{
			$t->increments('id')->unsigned();
			$t->integer('message_id');
			$t->integer('user_id');
			$t->integer('character_id');
			$t->boolean('read')->default((int) false);
			$t->boolean('status')->default(Status::ACTIVE);
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
		Schema::drop('messages');
		Schema::drop('message_recipients');
	}

}