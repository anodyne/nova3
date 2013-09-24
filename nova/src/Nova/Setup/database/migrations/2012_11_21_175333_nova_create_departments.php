<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateDepartments extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up($explicitGenre = false)
	{
		// Get the genre
		$genre = ($explicitGenre) ?: Config::get('nova.genre');

		Schema::create("departments_{$genre}", function($t)
		{
			$t->increments('id');
			$t->string('name');
			$t->text('desc')->nullable();
			$t->integer('order')->nullable();
			$t->boolean('status')->default(Status::ACTIVE);
			$t->string('type')->default('playing');
			$t->integer('parent_id')->unsigned()->default(0);
			$t->integer('manifest_id')->unsigned()->default(1);
			$t->timestamps();
		});

		if ($explicitGenre)
		{
			// Pull in the genre data file
			include SRCPATH."Setup/database/genres/{$genre}.php";

			// Loop through the departments and seed the data
			foreach ($depts as $d)
			{
				DeptModel::create($d);
			}
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down($explicitGenre = false)
	{
		// Get the genre
		$genre = ($explicitGenre) ?: Config::get('nova.genre');

		Schema::drop("departments_{$genre}");
	}

}