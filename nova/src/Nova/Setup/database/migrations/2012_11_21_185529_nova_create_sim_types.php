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

		// Data to seed the database with
		$data = array(
			array('name' => 'all'),
			array('name' => 'ship'),
			array('name' => 'base'),
			array('name' => 'colony'),
			array('name' => 'unit'),
			array('name' => 'realm'),
			array('name' => 'planet'),
			array('name' => 'organization'),
		);

		// Loop through the data and add it
		foreach ($data as $d)
		{
			SimType::add($d);
		}
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