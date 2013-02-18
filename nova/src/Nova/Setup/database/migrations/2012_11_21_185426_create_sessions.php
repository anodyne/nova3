<?php

use Illuminate\Database\Migrations\Migration;

class CreateSessions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sessions', function($table)
		{
			$table->string('id', 40)->unique();
			$table->integer('last_activity');
			$table->text('data');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sessions');
	}
}
