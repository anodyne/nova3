<?php namespace Tests\Authorize;

use Nova\Authorize\Role;
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

		$this->signIn();

		$this->get(route('roles.index'))->assertStatus(403);
		$this->get(route('roles.create'))->assertStatus(403);
		$this->post(route('roles.store'))->assertStatus(403);
		$this->get(route('roles.edit', $this->role))->assertStatus(403);
		$this->patch(route('roles.update', $this->role))->assertStatus(403);
		$this->delete(route('roles.destroy', $this->role))->assertStatus(403);
	}

	/** @test **/
	public function a_role_can_be_created()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$permission = create('Nova\Authorize\Permission');

		$role = make('Nova\Authorize\Role');

		$this->post(
			route('roles.store'),
			array_merge($role->toArray(), ['permissions' => [$permission->id]])
		);

		$createdRole = Role::orderByDesc('id')->first();

		$this->assertDatabaseHas('roles', ['name' => $role->name]);
		$this->assertDatabaseHas('permissions_roles', [
			'role_id' => $createdRole->id,
			'permission_id' => $permission->id
		]);
	}

	/** @test **/
	public function a_role_can_be_updated()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$permission1 = create('Nova\Authorize\Permission');
		$permission2 = create('Nova\Authorize\Permission');

		$this->role->permissions()->sync([$permission1->id]);

		$this->patch(
			route('roles.update', [$this->role]),
			['name' => 'New Name', 'permissions' => [$permission2->id]]
		);

		$this->assertDatabaseHas('roles', ['name' => 'New Name']);
		$this->assertDatabaseMissing('permissions_roles', [
			'role_id' => $this->role->id,
			'permission_id' => $permission1->id
		]);
		$this->assertDatabaseHas('permissions_roles', [
			'role_id' => $this->role->id,
			'permission_id' => $permission2->id
		]);
	}

	/** @test **/
	public function a_role_can_be_deleted()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$permission = create('Nova\Authorize\Permission');

		$this->role->permissions()->sync([$permission->id]);

		$this->delete(route('roles.destroy', [$this->role]));

		$this->assertDatabaseMissing('roles', ['name' => $this->role->name]);
		$this->assertDatabaseMissing('permissions_roles', ['role_id' => $this->role->id]);
	}
}
