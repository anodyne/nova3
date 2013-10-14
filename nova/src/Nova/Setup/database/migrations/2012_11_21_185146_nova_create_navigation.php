<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NovaCreateNavigation extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('navigation', function(Blueprint $t)
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
			$t->boolean('status')->default(Status::ACTIVE);
			$t->integer('sim_type')->default(1);
			$t->timestamps();
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