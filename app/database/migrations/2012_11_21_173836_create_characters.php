<?php

use Illuminate\Database\Migrations\Migration;

class CreateCharacters extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('characters', function($table)
		{
			$table->increments('id');
			$table->integer('user_id')->default(0);
			$table->integer('status')->default(1);
			$table->string('first_name')->nullable();
			$table->string('middle_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('suffix')->nullable();
			$table->integer('rank_id')->default(1);
			$table->datetime('activated');
			$table->datetime('deactivated');
			$table->datetime('last_post');
			$table->timestamps();
		});

		Schema::create('character_images', function($table)
		{
			$table->increments('id')->unsigned();
			$table->integer('user_id');
			$table->integer('character_id');
			$table->text('image');
			$table->boolean('primary')->default(0);
			$table->integer('created_by');
			$table->datetime('created_at');
		});

		Schema::create('character_positions', function($table)
		{
			$table->increments('id')->unsigned();
			$table->integer('character_id');
			$table->integer('position_id');
			$table->boolean('primary')->default(0);
		});

		Schema::create('character_promotions', function($table)
		{
			$table->increments('id')->unsigned();
			$table->integer('user_id');
			$table->integer('character_id');
			$table->integer('old_order');
			$table->string('old_rank');
			$table->integer('new_order');
			$table->string('new_rank');
			$table->datetime('created_at');
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
		Schema::drop('character_images');
		Schema::drop('character_positions');
		Schema::drop('character_promotions');
	}
}
