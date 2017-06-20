<?php namespace Tests\Authorize;

use Tests\DatabaseTestCase;

class ManagePermissionsTests extends DatabaseTestCase
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
		$this->put(route('permissions.update', $this->permission))->assertRedirect(route('login'));
		$this->delete(route('permissions.destroy', $this->permission))->assertRedirect(route('login'));

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
	public function a_permission_can_be_created()
	{
		$this->signIn();

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
		$this->signIn();

		$this->put(
			route('permissions.update',
			[$this->permission]),
			['name' => 'New Name', 'key' => $this->permission->key]
		);

		$this->assertDatabaseHas('permissions', ['name' => 'New Name']);
	}

	/** @test **/
	public function a_permission_can_be_deleted()
	{
		$this->signIn();

		$this->delete(route('permissions.destroy', [$this->permission]));

		$this->assertDatabaseMissing('permissions', ['name' => $this->permission->name]);
	}
}
