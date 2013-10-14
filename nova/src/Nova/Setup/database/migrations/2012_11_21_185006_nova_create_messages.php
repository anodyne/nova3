<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NovaCreateMessages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function(Blueprint $t)
		{
			$t->bigIncrements('id');
			$t->integer('user_id')->unsigned();
			$t->integer('character_id')->unsigned();
			$t->string('subject');
			$t->text('content');
			$t->boolean('status')->default(Status::ACTIVE);
			$t->timestamps();
		});

		Schema::create('message_recipients', function(Blueprint $t)
		{
			$t->bigIncrements('id');
			$t->integer('message_id')->unsigned();
			$t->integer('user_id')->unsigned();
			$t->integer('character_id')->unsigned();
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