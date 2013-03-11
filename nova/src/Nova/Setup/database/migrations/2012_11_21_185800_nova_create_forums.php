<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateForums extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('forum_posts', function($t)
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
		Schema::drop('forum_posts');
	}

}