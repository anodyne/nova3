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
			$t->integer('category_id')->unsigned()->nullable();
			$t->string('image')->nullable();
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
			$t->bigIncrements('id');
			$t->integer('character_id')->unsigned();
			$t->integer('user_id')->unsigned();
			$t->integer('sender_user_id')->unsigned();
			$t->integer('award_id')->unsigned();
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
