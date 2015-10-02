<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessTables extends Migration {
	
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create table for storing roles
		Schema::create('roles', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('display_name')->nullable();
			$table->string('description')->nullable();
			$table->timestamps();
		});

		// Create table for associating roles to users (Many-to-Many)
		Schema::create('users_roles', function (Blueprint $table) {
			$table->integer('user_id')->unsigned();
			$table->integer('role_id')->unsigned();

			$table->foreign('user_id')->references('id')->on('users')
				->onDelete('cascade');
			$table->foreign('role_id')->references('id')->on('roles')
				->onDelete('cascade');

			$table->primary(['user_id', 'role_id']);
		});

		// Create table for storing permissions
		Schema::create('permissions', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('display_name')->nullable();
			$table->string('description')->nullable();
			$table->boolean('protected')->default((int) false);
			$table->timestamps();
		});

		// Create table for associating permissions to roles (Many-to-Many)
		Schema::create('roles_permissions', function (Blueprint $table) {
			$table->integer('permission_id')->unsigned();
			$table->integer('role_id')->unsigned();

			$table->foreign('permission_id')->references('id')->on('permissions')
				->onDelete('cascade');
			$table->foreign('role_id')->references('id')->on('roles')
				->onDelete('cascade');

			$table->primary(['permission_id', 'role_id']);
		});

		$this->populateTables();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('roles_permissions');
		Schema::dropIfExists('permissions');
		Schema::dropIfExists('users_roles');
		Schema::dropIfExists('roles');
	}

	protected function populateTables()
	{
		Model::unguard();

		$data = require_once app('path.database').'/data/access.php';

		foreach ($data['permissions'] as $permission)
		{
			Permission::create($permission);
		}

		foreach ($data['roles'] as $role)
		{
			$role = Role::create($role);

			foreach ($data['roleAssociations'][$role->display_name] as $ra)
			{
				$role->permissions()->attach($ra);
			}
		}
	}
}
