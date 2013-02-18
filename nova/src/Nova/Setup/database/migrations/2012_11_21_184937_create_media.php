<?php

use Illuminate\Database\Migrations\Migration;

class CreateMedia extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('media', function($table)
		{
			$table->increments('id')->unsigned();
			$table->text('filename')->nullable();
			$table->string('mime_type')->nullable();
			$table->string('resource_type')->nullable();
			$table->integer('user_id');
			$table->string('ip_address', 16);
			$table->timestamps();
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
