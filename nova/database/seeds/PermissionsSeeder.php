<?php

use Nova\Authorize\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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

			['name' => "Create departments", 'key' => "dept.create"],
			['name' => "Update departments", 'key' => "dept.update"],
			['name' => "Delete departments", 'key' => "dept.delete"],

			['name' => "Create positions", 'key' => "position.create"],
			['name' => "Update positions", 'key' => "position.update"],
			['name' => "Delete positions", 'key' => "position.delete"],

			['name' => "Create ranks", 'key' => "rank.create"],
			['name' => "Update ranks", 'key' => "rank.update"],
			['name' => "Delete ranks", 'key' => "rank.delete"],

			['name' => "Create characters", 'key' => "character.create"],
			['name' => "Update characters", 'key' => "character.update"],
			['name' => "Delete characters", 'key' => "character.delete"],

			['name' => "Create settings", 'key' => "settings.create"],
			['name' => "Update settings", 'key' => "settings.update"],
			['name' => "Delete settings", 'key' => "settings.delete"],

			['name' => "Create extensions", 'key' => "extension.create"],
			['name' => "Update extensions", 'key' => "extension.update"],
			['name' => "Delete extensions", 'key' => "extension.delete"],

			['name' => "Webmaster", 'key' => "system.update"],
		];

		Permission::insert($permissions);
    }
}
