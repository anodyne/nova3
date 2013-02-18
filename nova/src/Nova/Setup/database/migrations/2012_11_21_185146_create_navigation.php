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
		Schema::create('navigation', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->integer('group')->nullable();
			$table->integer('order')->nullable();
			$table->text('url');
			$table->string('url_target')->default('onsite');
			$table->string('needs_login')->default('none');
			$table->string('access');
			$table->string('type');
			$table->string('category');
			$table->boolean('status')->default(3);
			$table->integer('sim_type')->default(1);
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
