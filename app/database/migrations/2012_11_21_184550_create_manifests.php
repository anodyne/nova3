<?php

use Illuminate\Database\Migrations\Migration;

class CreateManifests extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('manifests', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->integer('order')->nullable();
			$table->text('desc')->nullable();
			$table->text('header_content')->nullable();
			$table->boolean('status')->default(3);
			$table->boolean('default')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('manifests');
	}
}
