<?php

use Illuminate\Database\Migrations\Migration;

class CreateBans extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bans', function($table)
		{
			$table->increments('id');
			$table->integer('level')->default(1);
			$table->string('ip_address', 16)->nullable();
			$table->string('email', 100)->nullable();
			$table->text('reason')->nullable();
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
		Schema::drop('bans');
	}
}
