<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateAnnouncements extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('announcements', function($t)
		{
			$t->increments('id');
			$t->string('title')->default('');
			$t->integer('user_id');
			$t->integer('character_id');
			$t->text('content');
			$t->boolean('status')->default(Status::ACTIVE);
			$t->boolean('private')->default((int) false);
			$t->text('keywords')->nullable();
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
		Schema::drop('announcements');
	}
}
