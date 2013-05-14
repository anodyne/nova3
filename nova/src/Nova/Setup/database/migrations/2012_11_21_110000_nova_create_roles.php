<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateRoles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roles', function($t)
		{
			$t->increments('id');
			$t->string('name');
			$t->text('desc')->nullable();
			$t->text('inherits')->nullable();
			$t->timestamps();
		});

		Schema::create('roles_tasks', function($t)
		{
			$t->increments('id');
			$t->integer('role_id');
			$t->integer('task_id');
		});

		Schema::create('tasks', function($t)
		{
			$t->increments('id');
			$t->string('name');
			$t->string('desc')->nullable();
			$t->string('component', 100);
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