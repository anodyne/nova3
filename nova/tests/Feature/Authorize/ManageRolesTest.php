<?php namespace Tests\Authorize;

use RolesSeeder;
use PermissionsSeeder;
use Nova\Authorize\Role;
use Tests\DatabaseTestCase;


class ManageRolesTest extends DatabaseTestCase
{
	protected $role;

	public function setUp()
	{
		parent::setUp();

		$this->artisan('db:seed', ['--class' => PermissionsSeeder::class]);
		$this->artisan('db:seed', ['--class' => RolesSeeder::class]);

		$this->role = factory(Role::class)->create();
	}

	/**
	 * @test
	 * @coversNothing
	 */
	public function unauthorized_users_cannot_manage_roles()
	{
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

	/**
	 * @test
	 * @covers Nova\Authorize\Http\Controllers\RolesController::store
	 */
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

	/**
	 * @test
	 * @covers Nova\Authorize\Http\Controllers\RolesController::update
	 */
	public function a_role_can_be_updated()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$permission1 = create('Nova\Authorize\Permission');
		$permission2 = create('Nova\Authorize\Permission');

		$this->role->permissions()->sync([$permission1->id]);

		$this->patch(
			route('roles.update', [$this->role]),
			['name' => "New Name", 'permissions' => [$permission2->id]]
		);

		$this->assertDatabaseHas('roles', ['name' => "New Name"]);
		$this->assertDatabaseMissing('permissions_roles', [
			'role_id' => $this->role->id,
			'permission_id' => $permission1->id
		]);
		$this->assertDatabaseHas('permissions_roles', [
			'role_id' => $this->role->id,
			'permission_id' => $permission2->id
		]);
	}

	/**
	 * @test
	 * @covers Nova\Authorize\Http\Controllers\RolesController::destroy
	 */
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

	/**
	 * @test
	 * @coversNothing
	 */
	public function role_management_has_no_errors()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$this->get(route('roles.index'))->assertSuccessful();
		$this->get(route('roles.create'))->assertSuccessful();
		$this->get(route('roles.edit', $this->role))->assertSuccessful();
	}
}
