<?php namespace Tests\Authorize;

use Nova\Authorize\Role;
use Tests\DatabaseTestCase;

class RoleUpdaterTest extends DatabaseTestCase
{
	/** @test **/
	public function it_updates_permissions_on_update()
	{
		$permission1 = create('Nova\Authorize\Permission');
		$permission2 = create('Nova\Authorize\Permission');

		$role = creator(Role::class)->data([
			'name' => "Role name",
			'permissions' => [$permission1->id]
		])->create();

		$role = updater(Role::class)->data([
			'permissions' => [$permission2->id]
		])->update($role);

		$this->assertDatabaseHas('permissions_roles', [
			'role_id' => $role->id,
			'permission_id' => $permission2->id
		]);
		$this->assertCount(1, $role->fresh()->permissions);
	}
}
