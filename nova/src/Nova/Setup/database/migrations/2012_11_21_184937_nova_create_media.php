<?php

use Illuminate\Database\Migrations\Migration;

class NovaCreateMedia extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('media', function($t)
		{
			$t->increments('id')->unsigned();
			$t->text('filename')->nullable();
			$t->string('mime_type')->nullable();
			$t->string('resource_type')->nullable();
			$t->integer('user_id');
			$t->string('ip_address', 16);
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
		Schema::drop('media');
	}
}
