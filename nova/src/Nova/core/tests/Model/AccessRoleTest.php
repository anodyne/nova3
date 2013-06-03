<?php

use Mockery as m;
use Nova\Core\Lib\TestCase;

class AccessRoleTest extends TestCase {

	public function tearDown()
	{
		m::close();
	}

	// Test relationships

	public function testGettingInheritedRolesReturnsArray()
	{
		$role = new AccessRole;
		$role->inherits = '1,2';

		$this->assertInternalType('array', $role->inherits);
	}

	// getTasks

	// getInheritedTasks

	public function testGettingId()
	{
		# code...
	}

	public function testGettingName()
	{
		# code...
	}

	public function testGettingPermissions()
	{
		# code...
	}

}