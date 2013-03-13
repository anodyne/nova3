<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateCharacters extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('characters', function($t)
		{
			$t->increments('id');
			$t->integer('user_id')->default(0);
			$t->integer('status')->default(Status::PENDING);
			$t->string('first_name')->nullable();
			$t->string('middle_name')->nullable();
			$t->string('last_name')->nullable();
			$t->string('suffix')->nullable();
			$t->integer('rank_id')->default(1);
			$t->datetime('activated')->nullable();
			$t->datetime('deactivated')->nullable();
			$t->datetime('last_post')->nullable();
			$t->timestamps();
		});

		Schema::create('character_positions', function($t)
		{
			$t->increments('id')->unsigned();
			$t->integer('character_id');
			$t->integer('position_id');
			$t->boolean('primary')->default((int) false);
		});

		Schema::create('character_promotions', function($t)
		{
			$t->increments('id')->unsigned();
			$t->integer('character_id');
			$t->integer('old_order');
			$t->string('old_rank');
			$t->integer('new_order');
			$t->string('new_rank');
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
		Schema::drop('characters');
		Schema::drop('character_positions');
		Schema::drop('character_promotions');
	}

}