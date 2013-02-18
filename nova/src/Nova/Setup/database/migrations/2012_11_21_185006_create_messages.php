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
		Schema::create('messages', function($table)
		{
			$table->increments('id')->unsigned();
			$table->integer('user_id');
			$table->integer('character_id');
			$table->string('subject');
			$table->text('content');
			$table->boolean('status')->default(3);
			$table->datetime('created_at');
		});

		Schema::create('message_recipients', function($table)
		{
			$table->increments('id')->unsigned();
			$table->integer('message_id');
			$table->integer('user_id');
			$table->integer('character_id');
			$table->boolean('read')->default(0);
			$table->boolean('status')->default(3);
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
