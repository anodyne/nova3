<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateMissions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('missions', function($t)
		{
			$t->increments('id');
			$t->string('title');
			$t->integer('order');
			$t->integer('group_id')->unsigned()->nullable();
			$t->boolean('status')->default(Status::PENDING);
			$t->date('start_date')->nullable();
			$t->date('end_date')->nullable();
			$t->text('desc');
			$t->text('summary')->nullable();
			$t->timestamps();
		});

		Schema::create('mission_groups', function($t)
		{
			$t->increments('id');
			$t->string('name');
			$t->integer('order');
			$t->text('desc')->nullable();
			$t->integer('parent_id')->unsigned()->nullable();
			$t->timestamps();
		});

		Schema::create('mission_notes', function($t)
		{
			$t->increments('id');
			$t->integer('mission_id')->unsigned();
			$t->text('content');
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
		Schema::drop('missions');
		Schema::drop('mission_groups');
		Schema::drop('mission_notes');
	}

}