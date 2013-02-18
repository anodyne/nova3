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
		Schema::create('missions', function($table)
		{
			$table->increments('id');
			$table->string('title');
			$table->text('images')->nullable();
			$table->integer('order');
			$table->integer('group_id');
			$table->boolean('status')->default(1);
			$table->date('start_date');
			$table->date('end_date');
			$table->text('desc');
			$table->text('summary')->nullable();
			$table->text('notes')->nullable();
			$table->datetime('notes_updated_at');
			$table->timestamps();
		});

		Schema::create('mission_groups', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->integer('order');
			$table->text('desc');
			$table->integer('parent_id')->nullable();
			$table->timestamps();
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
