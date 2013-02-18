<?php

use Illuminate\Database\Migrations\Migration;

class CreateModeration extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('moderation', function($table)
		{
			$table->increments('id');
			$table->integer('user_id')->nullable();
			$table->integer('character_id')->nullable();
			$table->string('type', 100)->nullable();
			$table->datetime('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('moderation');
	}
}
