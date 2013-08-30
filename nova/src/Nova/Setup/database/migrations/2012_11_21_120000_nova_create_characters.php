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
			$t->integer('user_id')->unsigned()->default(0);
			$t->integer('status')->default(Status::PENDING);
			$t->string('first_name')->nullable();
			$t->string('middle_name')->nullable();
			$t->string('last_name')->nullable();
			$t->string('suffix')->nullable();
			$t->integer('rank_id')->unsigned()->default(1);
			$t->datetime('activated_at')->nullable();
			$t->datetime('deactivated_at')->nullable();
			$t->datetime('last_post')->nullable();
			$t->timestamps();
		});

		Schema::create('character_positions', function($t)
		{
			$t->bigIncrements('id');
			$t->integer('character_id')->unsigned();
			$t->integer('position_id')->unsigned();
			$t->boolean('primary')->default((int) false);
		});

		Schema::create('character_promotions', function($t)
		{
			$t->increments('id');
			$t->integer('character_id')->unsigned();
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