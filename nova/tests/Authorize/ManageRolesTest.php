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
		$this->patch(route('roles.update', $this->role))->assertRedirect(route('login'));
		$this->delete(route('roles.destroy', $this->role))->assertRedirect(route('login'));

		// $this->signIn();

		// $this->get(route('roles.index'))->assertStatus(403);
		// $this->get(route('roles.create'))->assertStatus(403);
		// $this->post(route('roles.store'))->assertStatus(403);
		// $this->get(route('roles.edit', $this->role))->assertStatus(403);
		// $this->patch(route('roles.update', $this->role))->assertStatus(403);
		// $this->patch(route('roles.restore', $this->role))->assertStatus(403);
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
			array_merge($role->toArray(), ['permissions' => [6, 7, 11]])
		);

		$this->assertDatabaseHas('roles', ['name' => $role->name]);
		$this->assertDatabaseHas('permissions_roles', ['role_id' => 3, 'permission_id' => 6]);
		$this->assertDatabaseHas('permissions_roles', ['role_id' => 3, 'permission_id' => 7]);
		$this->assertDatabaseHas('permissions_roles', ['role_id' => 3, 'permission_id' => 11]);
	}

	/** @test **/
	public function a_role_can_be_updated()
	{
		$this->signIn();

		create('Nova\Authorize\Permission', [], 5);

		$this->role->permissions()->sync([6, 7, 11]);

		$this->patch(
			route('roles.update', [$this->role]),
			['name' => 'New Name', 'permissions' => [8, 9]]
		);

		$this->assertDatabaseHas('roles', ['name' => 'New Name']);
		$this->assertDatabaseMissing('permissions_roles', ['role_id' => 2, 'permission_id' => 6]);
		$this->assertDatabaseMissing('permissions_roles', ['role_id' => 2, 'permission_id' => 7]);
		$this->assertDatabaseMissing('permissions_roles', ['role_id' => 2, 'permission_id' => 11]);
		$this->assertDatabaseHas('permissions_roles', ['role_id' => 2, 'permission_id' => 8]);
		$this->assertDatabaseHas('permissions_roles', ['role_id' => 2, 'permission_id' => 9]);
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
