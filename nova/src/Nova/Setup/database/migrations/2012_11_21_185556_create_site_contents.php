<?php

use Illuminate\Database\Migrations\Migration;

class CreateSiteContents extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('site_contents', function($t)
		{
			$t->increments('id');
			$t->string('key');
			$t->string('label')->nullable();
			$t->text('content')->nullable();
			$t->string('type');
			$t->string('section', 50)->nullable();
			$t->string('page', 100)->nullable();
			$t->boolean('protected')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('site_contents');
	}
}
