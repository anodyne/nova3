<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateDepartments extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Get the genre
		$genre = Config::get('nova.genre');

		Schema::create("departments_{$genre}", function($t)
		{
			$t->increments('id');
			$t->string('name');
			$t->text('desc')->nullable();
			$t->integer('order')->nullable();
			$t->boolean('status')->default(Status::ACTIVE);
			$t->string('type')->default('playing');
			$t->integer('parent_id')->default(0);
			$t->integer('manifest_id')->default(1);
			$t->timestamps();
		});

		// Pull in the genre data file
		include SRCPATH."Setup/assets/install/genres/{$genre}.php";

		// Loop through the departments and seed the data
		foreach ($depts as $d)
		{
			DeptModel::createItem($d);
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Get the genre
		$genre = Config::get('nova.genre');

		Schema::drop("departments_{$genre}");
	}

}