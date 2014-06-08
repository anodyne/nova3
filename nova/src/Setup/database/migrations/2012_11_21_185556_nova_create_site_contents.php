<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NovaCreateSiteContents extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('site_contents', function(Blueprint $t)
		{
			$t->increments('id');
			$t->string('key')->unique();
			$t->string('label');
			$t->text('content')->nullable();
			$t->string('type');
			$t->string('uri')->nullable();
			$t->string('section', 50)->nullable();
			$t->string('page', 100)->nullable();
			$t->boolean('protected')->default((int) false);
			$t->string('mode')->nullable();
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