<?php

use Nova\Authorize\Role;
use Nova\Authorize\Permission;
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

		$this->seed();
	}

	public function down()
	{
		Schema::dropIfExists('permissions_roles');
		Schema::dropIfExists('users_roles');
		Schema::dropIfExists('permissions');
		Schema::dropIfExists('roles');
	}

	public function seed()
	{
		// Create permissions
		$permissions = [
			['name' => "Create roles", 'key' => "role.create"],
			['name' => "Update roles", 'key' => "role.update"],
			['name' => "Delete roles", 'key' => "role.delete"],

			['name' => "Create permissions", 'key' => "permission.create"],
			['name' => "Update permissions", 'key' => "permission.update"],
			['name' => "Delete permissions", 'key' => "permission.delete"],

			['name' => "Create users", 'key' => "user.create"],
			['name' => "Update users", 'key' => "user.update"],
			['name' => "Delete users", 'key' => "user.delete"],
		];

		foreach ($permissions as $permission) {
			Permission::create($permission);
		}

		// Create roles
		$roles = [
			['name' => 'System Admin']
		];

		foreach ($roles as $role) {
			Role::create($role);
		}
	}
}
