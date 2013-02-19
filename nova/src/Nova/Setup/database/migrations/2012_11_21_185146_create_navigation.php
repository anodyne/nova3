<?php

use Illuminate\Database\Migrations\Migration;

class CreateNavigation extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('navigation', function($t)
		{
			$t->increments('id');
			$t->string('name');
			$t->integer('group')->nullable();
			$t->integer('order')->nullable();
			$t->text('url');
			$t->string('url_target')->default('onsite');
			$t->string('needs_login')->default('none');
			$t->string('access');
			$t->string('type');
			$t->string('category');
			$t->boolean('status')->default(3);
			$t->integer('sim_type')->default(1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('navigation');
	}
}
