<?php

use Illuminate\Database\Migrations\Migration;

class CreateAwards extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('awards', function($t)
		{
			$t->increments('id');
			$t->string('name')->nullable();
			$t->string('image', 100)->nullable();
			$t->integer('category_id')->nullable();
			$t->integer('order')->nullable();
			$t->text('desc')->nullable();
			$t->string('type')->default('ic');
			$t->boolean('status')->default(3);
		});

		Schema::create('award_categories', function($t)
		{
			$t->increments('id');
			$t->string('name')->nullable();
			$t->text('desc')->nullable();
			$t->boolean('status')->default(3);
		});

		Schema::create('award_queue', function($t)
		{
			$t->increments('id');
			$t->integer('receiver_user_id');
			$t->integer('sender_user_id');
			$t->integer('award_id');
			$t->text('reason')->nullable();
			$t->boolean('status')->default(3);
			$t->datetime('created_at');
		});

		Schema::create('award_received', function($t)
		{
			$t->increments('id');
			$t->integer('receiver_user_id');
			$t->integer('sender_user_id');
			$t->integer('award_id');
			$t->text('reason')->nullable();
			$t->datetime('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('awards');
		Schema::drop('award_categories');
		Schema::drop('award_queue');
		Schema::drop('award_received');
	}
}
