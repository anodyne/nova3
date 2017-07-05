<?php namespace Tests\Authorize;

use Nova\Authorize\Role;
use Tests\DatabaseTestCase;

class RoleCreatorTest extends DatabaseTestCase
{
	/** @test **/
	public function it_attaches_permissions_on_create()
	{
		$permission = create('Nova\Authorize\Permission');

		$role = creator(Role::class)->data([
			'name' => "Role name",
			'permissions' => [$permission->id]
		])->create();

		$this->assertDatabaseHas('permissions_roles', [
			'role_id' => $role->id,
			'permission_id' => $permission->id
		]);
		$this->assertCount(1, $role->fresh()->permissions);
	}
}
