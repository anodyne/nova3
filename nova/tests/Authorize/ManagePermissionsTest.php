<?php namespace Tests\Authorize;

use Tests\DatabaseTestCase;
use Nova\Authorize\Permission;

class ManagePermissionsTest extends DatabaseTestCase
{
	protected $permission;

	public function setUp()
	{
		parent::setUp();

		$this->permission = create(Permission::class);
	}

	/**
	 * @test
	 * @coversNothing
	 */
	public function unauthorized_users_cannot_manage_permissions()
	{
		$this->withExceptionHandling();

		$this->get(route('permissions.index'))->assertRedirect(route('sign-in'));
		$this->get(route('permissions.create'))->assertRedirect(route('sign-in'));
		$this->post(route('permissions.store'))->assertRedirect(route('sign-in'));
		$this->get(route('permissions.edit', $this->permission))->assertRedirect(route('sign-in'));
		$this->patch(route('permissions.update', $this->permission))->assertRedirect(route('sign-in'));
		$this->delete(route('permissions.destroy', $this->permission))->assertRedirect(route('sign-in'));

		$this->signIn();

		$this->get(route('permissions.index'))->assertStatus(403);
		$this->get(route('permissions.create'))->assertStatus(403);
		$this->post(route('permissions.store'))->assertStatus(403);
		$this->get(route('permissions.edit', $this->permission))->assertStatus(403);
		$this->patch(route('permissions.update', $this->permission))->assertStatus(403);
		$this->delete(route('permissions.destroy', $this->permission))->assertStatus(403);
	}

	/**
	 * @test
	 * @covers Nova\Http\Controllers\PermissionsController::store
	 */
	public function a_permission_can_be_created()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$permission = make(Permission::class);

		$this->post(route('permissions.store'), $permission->toArray());

		$this->assertDatabaseHas('permissions', [
			'name' => $permission->name,
			'key' => $permission->key
		]);
	}

	/**
	 * @test
	 * @covers Nova\Http\Controllers\PermissionsController::update
	 */
	public function a_permission_can_be_updated()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$this->patch(
			route('permissions.update', [$this->permission]),
			['name' => 'New Name', 'key' => $this->permission->key]
		);

		$this->assertDatabaseHas('permissions', ['name' => 'New Name']);
	}

	/**
	 * @test
	 * @covers Nova\Http\Controllers\PermissionsController::destroy
	 */
	public function a_permission_can_be_deleted()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$permission1 = create(Permission::class);
		$permission2 = create(Permission::class);
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

	/**
	 * @test
	 * @coversNothing
	 */
	public function permission_management_has_no_errors()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$this->get(route('permissions.index'))->assertSuccessful();
		$this->get(route('permissions.create'))->assertSuccessful();
		$this->get(route('permissions.edit', $this->permission))->assertSuccessful();
	}
}
