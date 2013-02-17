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
		Schema::create('site_contents', function($table)
		{
			$table->increments('id');
			$table->string('key');
			$table->string('label')->nullable();
			$table->text('content')->nullable();
			$table->string('type');
			$table->string('section', 50)->nullable();
			$table->string('page', 100)->nullable();
			$table->boolean('protected')->default(0);
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
