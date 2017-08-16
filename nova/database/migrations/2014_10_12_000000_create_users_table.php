<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedTinyInteger('status')->default(Status::PENDING);
			$table->unsignedInteger('primary_character')->nullable();
			$table->string('name');
			$table->string('email')->unique();
			$table->string('password')->nullable();
			$table->string('nickname')->nullable();
			$table->string('gender')->default('neutral')->nullable();
			$table->rememberToken();
			$table->datetime('last_sign_in')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::dropIfExists('users');
	}
}
