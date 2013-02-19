<?php

use Illuminate\Database\Migrations\Migration;

class CreateMissions extends Migration {

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
			$t->text('images')->nullable();
			$t->integer('order');
			$t->integer('group_id');
			$t->boolean('status')->default(1);
			$t->date('start_date');
			$t->date('end_date');
			$t->text('desc');
			$t->text('summary')->nullable();
			$t->text('notes')->nullable();
			$t->datetime('notes_updated_at');
			$t->timestamps();
		});

		Schema::create('mission_groups', function($t)
		{
			$t->increments('id');
			$t->string('name');
			$t->integer('order');
			$t->text('desc');
			$t->integer('parent_id')->nullable();
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
	}
}
