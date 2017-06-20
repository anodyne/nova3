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

		$role = make('Nova\Authorize\Role');

		$this->post(route('roles.store'), $role->toArray());

		$this->assertDatabaseHas('roles', ['name' => $role->name]);
	}

	/** @test **/
	public function a_role_can_be_updated()
	{
		$this->signIn();

		$this->put(route('roles.update', [$this->role]), ['name' => 'New Name']);

		$this->assertDatabaseHas('roles', ['name' => 'New Name']);
	}

	/** @test **/
	public function a_role_can_be_deleted()
	{
		$this->signIn();

		$this->delete(route('roles.destroy', [$this->role]));

		$this->assertDatabaseMissing('roles', ['name' => $this->role->name]);
	}
}
