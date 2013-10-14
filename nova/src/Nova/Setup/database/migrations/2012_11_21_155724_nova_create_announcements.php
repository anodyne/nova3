<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NovaCreateAnnouncements extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('announcements', function(Blueprint $t)
		{
			$t->increments('id');
			$t->string('title')->default('');
			$t->integer('user_id')->unsigned();
			$t->integer('character_id')->unsigned();
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
