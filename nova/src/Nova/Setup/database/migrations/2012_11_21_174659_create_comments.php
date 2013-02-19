<?php

use Illuminate\Database\Migrations\Migration;

class CreateComments extends Migration {

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
			$t->integer('user_id');
			$t->integer('character_id');
			$t->integer('commentable_id');
			$t->string('commentable_type', 100);
			$t->text('content');
			$t->boolean('status')->default(3);
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
