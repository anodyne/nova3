<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateWiki extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wiki_pages', function($t)
		{
			$t->increments('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('wiki_pages');
	}

}