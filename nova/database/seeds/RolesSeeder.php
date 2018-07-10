<?php

use Nova\Authorize\Role;
use Nova\Authorize\Permission;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
			['name' => 'System Admin', 'permissions' => ['role.create', 'role.update', 'role.delete', 'permission.create', 'permission.update', 'permission.delete', 'user.create', 'user.update', 'user.delete', 'dept.create', 'dept.delete', 'dept.update', 'position.create', 'position.delete', 'position.update', 'rank.create', 'rank.delete', 'rank.update', 'character.create', 'character.delete', 'character.update', 'settings.create', 'settings.update', 'settings.delete', 'system.update', 'extension.create', 'extension.update', 'extension.delete']],

			['name' => 'Power User', 'permissions' => []],

			['name' => 'Active User', 'permissions' => []],

			['name' => 'Inactive User', 'permissions' => []],
		];

		collect($roles)->each(function ($role) {
			$permissionKeys = $role['permissions'];
			unset($role['permissions']);

			$newRole = Role::create($role);

			$permissionIds = Permission::whereIn('key', $permissionKeys)
				->get()
				->map(function ($p) { return $p->id; });

			if ($permissionIds->count() > 0) {
				$newRole->permissions()->attach($permissionIds->all());
			}
		});

		cache()->rememberForever('nova.permissions', function () {
			return Permission::with('roles')->get();
		});

		cache()->rememberForever('nova.roles', function () {
			return Role::with('permissions')->get();
		});
    }
}
