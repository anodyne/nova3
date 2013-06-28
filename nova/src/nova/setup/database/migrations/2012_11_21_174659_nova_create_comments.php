<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateComments extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function($t)
		{
			$t->increments('id');
			$t->integer('commentable_id')->unsigned();
			$t->string('commentable_type', 100);
			$t->integer('user_id')->unsigned();
			$t->integer('character_id')->unsigned();
			$t->text('content');
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
		Schema::drop('comments');
	}

}