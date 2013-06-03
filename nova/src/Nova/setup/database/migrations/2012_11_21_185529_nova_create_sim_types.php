<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateSimTypes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sim_types', function($t)
		{
			$t->increments('id');
			$t->string('name', 50);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sim_types');
	}

}