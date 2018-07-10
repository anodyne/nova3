<?php

namespace Tests\Unit;

use Nova\Authorize\Role;
use Tests\DatabaseTestCase;
use Nova\Authorize\Permission;

class RoleTest extends DatabaseTestCase
{
	protected $role;

	public function setUp()
	{
		parent::setUp();

		$this->role = create(Role::class);
	}

	/**
	 * @test
	 * @covers Nova\Authorize\Role::permissions
	 */
	public function it_has_permissions()
	{
		$this->assertInstanceOf(
			'Illuminate\Database\Eloquent\Collection',
			$this->role->permissions
		);

		$permission = create(Permission::class);

		$this->role->permissions()->attach($permission->id);

		$this->assertCount(1, $this->role->fresh()->permissions);
	}

	/**
	 * @test
	 * @covers Nova\Authorize\Role::users
	 */
	public function it_has_users()
	{
		$this->assertInstanceOf(
			'Illuminate\Database\Eloquent\Collection',
			$this->role->users
		);

		$user = $this->createUser();

		$this->role->users()->attach($user->id);

		$this->assertCount(1, $this->role->fresh()->users);
	}

	/**
	 * @test
	 * @covers Nova\Authorize\Role::updatePermissions
	 */
	public function it_can_update_permissions()
	{
		$permission = create(Permission::class);

		$this->role->updatePermissions([$permission->id]);

		$this->assertCount(1, $this->role->fresh()->permissions);
	}

	/**
	 * @test
	 * @covers Nova\Authorize\Role::removePermissions
	 */
	public function it_can_remove_permissions()
	{
		$permission = create(Permission::class);

		$this->role->updatePermissions([$permission->id]);

		$this->role->removePermissions();

		$this->assertCount(0, $this->role->fresh()->permissions);
	}

	/** @test **/
	public function it_presents_included_permissions()
	{
		$permission1 = create(Permission::class);
		$permission2 = create(Permission::class);
		$permission3 = create(Permission::class);

		$this->role->updatePermissions([
			$permission1->id,
			$permission2->id,
			$permission3->id
		]);

		$this->assertEquals(
			"{$permission1->name}, {$permission2->name}, {$permission3->name}",
			$this->role->present()->includedPermissions
		);
	}

	/**
	 * @test
	 * @covers Nova\Authorize\Role::scopeName
	 */
	public function it_can_query_by_role_name()
	{
		$role = create(Role::class);

		$queriedRoles1 = Role::name($role->name)->get();
		$queriedRoles2 = Role::name('Foo')->get();

		$this->assertCount(1, $queriedRoles1);
		$this->assertCount(0, $queriedRoles2);
	}
}
