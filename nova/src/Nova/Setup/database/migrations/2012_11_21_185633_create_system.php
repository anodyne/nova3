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
		Schema::create('system_info', function($t)
		{
			$t->increments('id');
			$t->string('uid', 32);
			$t->boolean('version_major')->default(3);
			$t->boolean('version_minor');
			$t->boolean('version_patch');
			$t->string('ignore', 20)->nullable();
			$t->timestamps();
		});

		Schema::create('system_events', function($t)
		{
			$t->increments('id')->unsigned();
			$t->string('email', 100);
			$t->string('ip', 16);
			$t->integer('user_id')->nullable();
			$t->integer('character_id')->nullable();
			$t->text('content');
			$t->datetime('created_at');
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
