<?php

use Illuminate\Database\Migrations\Migration;

class CreateSettings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settings', function($t)
		{
			$t->increments('id');
			$t->string('key', 100);
			$t->text('value')->nullable();
			$t->string('label')->nullable();
			$t->text('help')->nullable();
			$t->boolean('user_created')->default(1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('settings');
	}
}
