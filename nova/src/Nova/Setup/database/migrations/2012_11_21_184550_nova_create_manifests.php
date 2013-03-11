<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateManifests extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('manifests', function($t)
		{
			$t->increments('id');
			$t->string('name');
			$t->integer('order')->nullable();
			$t->text('desc')->nullable();
			$t->text('header_content')->nullable();
			$t->boolean('status')->default(Status::ACTIVE);
			$t->boolean('default')->default(0);
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
