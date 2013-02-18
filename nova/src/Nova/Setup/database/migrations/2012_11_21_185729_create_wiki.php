<?php

use Illuminate\Database\Migrations\Migration;

class CreateWiki extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wiki_pages', function($table)
		{
			$table->increments('id');
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