<?php

use Illuminate\Database\Migrations\Migration;

class CreateDepartments extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		# TODO: need to load the genre from the config file
		$genre = 'st24';

		Schema::create("departments_$genre", function($t)
		{
			$t->increments('id');
			$t->string('name');
			$t->text('desc')->nullable();
			$t->integer('order')->nullable();
			$t->boolean('status')->default(3);
			$t->string('type')->default('playing');
			$t->integer('parent_id')->default(0);
			$t->integer('manifest_id')->default(1);
		});

		# TODO: need to figure out how to seed the departments
		//include NOVAPATH.'setup/assets/install/genres/'.strtolower(\Config::get('nova.genre')).'.php';
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		# TODO: need to load the genre from the config file
		$genre = 'st24';

		Schema::drop("departments_$genre");
	}
}
