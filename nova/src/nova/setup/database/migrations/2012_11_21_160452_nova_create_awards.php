<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateAwards extends Migration {

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
			$t->string('name');
			$t->integer('category_id')->nullable();
			$t->string('image', 100)->nullable();
			$t->integer('order')->nullable();
			$t->text('desc')->nullable();
			$t->string('type')->default('ic');
			$t->boolean('status')->default(Status::ACTIVE);
		});

		Schema::create('award_categories', function($t)
		{
			$t->increments('id');
			$t->string('name');
			$t->text('desc')->nullable();
			$t->boolean('status')->default(Status::ACTIVE);
		});

		Schema::create('award_recipients', function($t)
		{
			$t->increments('id');
			$t->integer('character_id');
			$t->integer('user_id');
			$t->integer('sender_user_id');
			$t->integer('award_id');
			$t->text('reason')->nullable();
			$t->boolean('status')->default(Status::PENDING);
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
		Schema::drop('awards');
		Schema::drop('award_categories');
		Schema::drop('award_recipients');
	}
}
