<?php namespace Tests\Authorize;

use Nova\Authorize\Role;
use Tests\DatabaseTestCase;

class RoleTest extends DatabaseTestCase
{
	protected $role;

	public function setUp()
	{
		parent::setUp();

		$this->role = create('Nova\Authorize\Role');
	}

	/** @test **/
	public function it_has_permissions()
	{
		$this->assertInstanceOf(
			'Illuminate\Database\Eloquent\Collection',
			$this->role->permissions
		);

		$permission = create('Nova\Authorize\Permission');

		$this->role->permissions()->attach($permission->id);

		$this->assertCount(1, $this->role->fresh()->permissions);
	}

	/** @test **/
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

	/** @test **/
	public function it_can_update_permissions()
	{
		$permission = create('Nova\Authorize\Permission');

		$this->role->updatePermissions([$permission->id]);

		$this->assertCount(1, $this->role->fresh()->permissions);
	}

	/** @test **/
	public function it_can_remove_permissions()
	{
		$permission = create('Nova\Authorize\Permission');

		$this->role->updatePermissions([$permission->id]);

		$this->assertCount(1, $this->role->fresh()->permissions);

		$this->role->removePermissions();

		$this->assertCount(0, $this->role->fresh()->permissions);
	}

	/** @test **/
	public function it_presents_included_permissions()
	{
		$permission1 = create('Nova\Authorize\Permission');
		$permission2 = create('Nova\Authorize\Permission');
		$permission3 = create('Nova\Authorize\Permission');

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
}
