<?php namespace Tests\Authorize;

use Tests\DatabaseTestCase;

class RoleRepositoryTest extends DatabaseTestCase
{
	/** @test **/
	public function it_cleans_up_permissions_on_delete()
	{
		$permission = create('Nova\Authorize\Permission');

		$role = create('Nova\Authorize\Role');
		$role->updatePermissions([$permission->id]);

		app('Nova\Authorize\Repositories\RoleRepositoryContract')->delete($role);

		$this->assertDatabaseMissing('permissions_roles', [
			'role_id' => $role->id,
			'permission_id' => $permission->id
		]);
	}
}
