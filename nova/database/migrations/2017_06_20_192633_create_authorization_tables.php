<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorizationTables extends Migration
{
	public function up()
	{
		Schema::create('roles', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name')->unique();
			$table->timestamps();
		});

		Schema::create('permissions', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('key')->unique();
			$table->timestamps();
		});

		Schema::create('users_roles', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('role_id');

			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('role_id')->references('id')->on('roles');
		});

		Schema::create('permissions_roles', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('permission_id');
			$table->unsignedInteger('role_id');

			$table->foreign('permission_id')->references('id')->on('permissions');
			$table->foreign('role_id')->references('id')->on('roles');
		});
	}

	public function down()
	{
		Schema::dropIfExists('permissions_roles');
		Schema::dropIfExists('users_roles');
		Schema::dropIfExists('permissions');
		Schema::dropIfExists('roles');
	}
}
