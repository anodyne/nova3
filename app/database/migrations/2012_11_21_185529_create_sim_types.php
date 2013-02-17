<?php

use Illuminate\Database\Migrations\Migration;

class CreateSimTypes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sim_types', function($table)
		{
			$table->increments('id');
			$table->string('name', 50);
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
