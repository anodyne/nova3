<?php namespace Tests\Authorize;

use Tests\DatabaseTestCase;

class ManagePermissionsTest extends DatabaseTestCase
{
	protected $permission;

	public function setUp()
	{
		parent::setUp();

		$this->permission = create('Nova\Authorize\Permission');
	}

	/** @test **/
	public function unauthorized_users_cannot_manage_permissions()
	{
		$this->withExceptionHandling();

		$this->get(route('permissions.index'))->assertRedirect(route('login'));
		$this->get(route('permissions.create'))->assertRedirect(route('login'));
		$this->post(route('permissions.store'))->assertRedirect(route('login'));
		$this->get(route('permissions.edit', $this->permission))->assertRedirect(route('login'));
		$this->patch(route('permissions.update', $this->permission))->assertRedirect(route('login'));
		$this->delete(route('permissions.destroy', $this->permission))->assertRedirect(route('login'));

		$this->signIn();

		$this->get(route('permissions.index'))->assertStatus(403);
		$this->get(route('permissions.create'))->assertStatus(403);
		$this->post(route('permissions.store'))->assertStatus(403);
		$this->get(route('permissions.edit', $this->permission))->assertStatus(403);
		$this->patch(route('permissions.update', $this->permission))->assertStatus(403);
		$this->delete(route('permissions.destroy', $this->permission))->assertStatus(403);
	}

	/** @test **/
	public function a_permission_can_be_created()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$permission = make('Nova\Authorize\Permission');

		$this->post(route('permissions.store'), $permission->toArray());

		$this->assertDatabaseHas('permissions', [
			'name' => $permission->name,
			'key' => $permission->key
		]);
	}

	/** @test **/
	public function a_permission_can_be_updated()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$this->patch(
			route('permissions.update', [$this->permission]),
			['name' => "New Name", 'key' => $this->permission->key]
		);

		$this->assertDatabaseHas('permissions', ['name' => "New Name"]);
	}

	/** @test **/
	public function a_permission_can_be_deleted()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$permission1 = create('Nova\Authorize\Permission');
		$permission2 = create('Nova\Authorize\Permission');

		$role1 = create('Nova\Authorize\Role');
		$role2 = create('Nova\Authorize\Role');

		$role1->permissions()->sync([$permission1->id, $permission2->id, $this->permission->id]);
		$role2->permissions()->sync([$permission2->id, $this->permission->id]);

		$this->delete(route('permissions.destroy', [$this->permission]));

		$this->assertDatabaseMissing('permissions', ['name' => $this->permission->name]);
		$this->assertDatabaseMissing('permissions_roles', ['permission_id' => $this->permission->id]);
		$this->assertDatabaseHas('permissions_roles', [
			'role_id' => $role1->id,
			'permission_id' => $permission1->id
		]);
		$this->assertDatabaseHas('permissions_roles', [
			'role_id' => $role1->id,
			'permission_id' => $permission2->id
		]);
		$this->assertDatabaseHas('permissions_roles', [
			'role_id' => $role2->id,
			'permission_id' => $permission2->id
		]);
	}
}
