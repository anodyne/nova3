<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('system_info', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('uid', 32);
			$table->tinyInteger('version_major')->default(3);
			$table->tinyInteger('version_minor')->default(0);
			$table->string('version_patch', 20)->default("0");
			$table->string('version_ignore', 20)->nullable();
			$table->timestamps();
		});

		Schema::create('system_events', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->string('email', 100)->nullable();
			$table->string('ip_address', 16);
			$table->integer('user_id')->unsigned()->nullable();
			$table->text('content');
			$table->timestamps();
		});

		// Create a new system record
		app('SystemRepository')->createSystemRecord();

		# TODO: create a new system event for the installation
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('system_info');
		Schema::dropIfExists('system_events');
	}

}
