<?php namespace Tests\Authorize;

use Tests\DatabaseTestCase;

class PermissionRepositoryTest extends DatabaseTestCase
{
	/** @test **/
	public function it_cleans_up_roles_on_delete()
	{
		$permission = create('Nova\Authorize\Permission');

		$role = create('Nova\Authorize\Role');
		$role->updatePermissions([$permission->id]);

		app('Nova\Authorize\Repositories\PermissionRepositoryContract')->delete($permission);

		$this->assertDatabaseMissing('permissions_roles', [
			'role_id' => $role->id,
			'permission_id' => $permission->id
		]);
	}
}
