<?php namespace Tests\Authorize;

use Tests\DatabaseTestCase;

class ManageRolesTests extends DatabaseTestCase
{
	protected $role;

	public function setUp()
	{
		parent::setUp();

		$this->role = create('Nova\Authorize\Role');
	}

	/** @test **/
	public function unauthorized_users_cannot_manage_roles()
	{
		$this->withExceptionHandling();

		$this->get(route('roles.index'))->assertRedirect(route('login'));
		$this->get(route('roles.create'))->assertRedirect(route('login'));
		$this->post(route('roles.store'))->assertRedirect(route('login'));
		$this->get(route('roles.edit', $this->role))->assertRedirect(route('login'));
		$this->put(route('roles.update', $this->role))->assertRedirect(route('login'));
		$this->delete(route('roles.destroy', $this->role))->assertRedirect(route('login'));

		// $this->signIn();

		// $this->get(route('roles.index'))->assertStatus(403);
		// $this->get(route('roles.create'))->assertStatus(403);
		// $this->post(route('roles.store'))->assertStatus(403);
		// $this->get(route('roles.edit', $this->role))->assertStatus(403);
		// $this->put(route('roles.update', $this->role))->assertStatus(403);
		// $this->put(route('roles.restore', $this->role))->assertStatus(403);
		// $this->delete(route('roles.destroy', $this->role))->assertStatus(403);
	}

	/** @test **/
	public function a_role_can_be_created()
	{
		$this->signIn();

		create('Nova\Authorize\Permission', [], 5);

		$role = make('Nova\Authorize\Role');

		$this->post(
			route('roles.store'),
			array_merge($role->toArray(), ['permissions' => [1, 2, 5]])
		);

		$this->assertDatabaseHas('roles', ['name' => $role->name]);
		$this->assertDatabaseHas('permissions_roles', ['role_id' => 2, 'permission_id' => 1]);
		$this->assertDatabaseHas('permissions_roles', ['role_id' => 2, 'permission_id' => 2]);
		$this->assertDatabaseHas('permissions_roles', ['role_id' => 2, 'permission_id' => 5]);
	}

	/** @test **/
	public function a_role_can_be_updated()
	{
		$this->signIn();

		create('Nova\Authorize\Permission', [], 5);

		$this->role->permissions()->sync([1, 2, 5]);

		$this->put(
			route('roles.update', [$this->role]),
			['name' => 'New Name', 'permissions' => [3, 4]]
		);

		$this->assertDatabaseHas('roles', ['name' => 'New Name']);
		$this->assertDatabaseMissing('permissions_roles', ['role_id' => 1, 'permission_id' => 1]);
		$this->assertDatabaseMissing('permissions_roles', ['role_id' => 1, 'permission_id' => 2]);
		$this->assertDatabaseMissing('permissions_roles', ['role_id' => 1, 'permission_id' => 5]);
		$this->assertDatabaseHas('permissions_roles', ['role_id' => 1, 'permission_id' => 3]);
		$this->assertDatabaseHas('permissions_roles', ['role_id' => 1, 'permission_id' => 4]);
	}

	/** @test **/
	public function a_role_can_be_deleted()
	{
		$this->signIn();

		create('Nova\Authorize\Permission', [], 5);

		$this->role->permissions()->sync([1, 2, 5]);

		$this->delete(route('roles.destroy', [$this->role]));

		$this->assertDatabaseMissing('roles', ['name' => $this->role->name]);
		$this->assertDatabaseMissing('permissions_roles', ['role_id' => $this->role->id]);
	}
}
