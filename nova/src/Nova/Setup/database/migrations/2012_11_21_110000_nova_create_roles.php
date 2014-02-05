<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NovaCreateRoles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roles', function(Blueprint $t)
		{
			$t->increments('id');
			$t->string('name');
			$t->string('slug');
			$t->text('desc')->nullable();
			$t->timestamps();
		});

		Schema::create('roles_tasks', function(Blueprint $t)
		{
			$t->increments('id');
			$t->integer('role_id')->unsigned();
			$t->integer('task_id')->unsigned();
		});

		Schema::create('tasks', function(Blueprint $t)
		{
			$t->increments('id');
			$t->string('name');
			$t->string('desc')->nullable();
			$t->string('component');
			$t->string('action', 11)->default('read');
			$t->boolean('level')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('roles');
		Schema::drop('roles_tasks');
		Schema::drop('tasks');
	}

}