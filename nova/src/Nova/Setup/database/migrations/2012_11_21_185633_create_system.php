<?php

use Illuminate\Database\Migrations\Migration;

class CreateSystem extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('system_info', function($table)
		{
			$table->increments('id');
			$table->string('uid', 32);
			$table->boolean('version_major')->default(3);
			$table->boolean('version_minor');
			$table->boolean('version_patch');
			$table->string('ignore', 20)->nullable();
			$table->timestamps();
		});

		Schema::create('system_events', function($table)
		{
			$table->increments('id')->unsigned();
			$table->string('email', 100);
			$table->string('ip', 16);
			$table->integer('user_id')->nullable();
			$table->integer('character_id')->nullable();
			$table->text('content');
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
		Schema::drop('system_info');
		Schema::drop('system_events');
	}
}
