<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NovaCreateMedia extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('media', function(Blueprint $t)
		{
			$t->bigIncrements('id');
			$t->integer('entry_id')->unsigned();
			$t->string('type', 100);
			$t->text('filename')->nullable();
			$t->string('mime_type')->nullable();
			$t->integer('user_id')->unsigned();
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