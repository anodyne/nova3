<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersCharactersTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('email', 100);
			$table->string('password', 96);
			$table->string('name');
			$table->string('nickname')->nullable();
			$table->rememberToken();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('users_password_resets', function (Blueprint $table)
		{
			$table->string('email')->index();
			$table->string('token')->index();
			$table->timestamp('created_at');
		});

		Schema::create('characters', function (Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('user_id')->unsigned()->nullable();
			$table->string('first_name');
			$table->string('middle_name')->nullable();
			$table->string('last_name')->nullable();
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('user_id')->references('id')->on('users')
				->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('characters');
		Schema::dropIfExists('users_password_resets');
		Schema::dropIfExists('users');
	}

}
