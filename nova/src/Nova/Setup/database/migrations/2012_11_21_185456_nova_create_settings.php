<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateSettings extends Migration {

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
			$t->boolean('user_created')->default((int) true);
			$t->boolean('show_basic_settings')->default((int) false);
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