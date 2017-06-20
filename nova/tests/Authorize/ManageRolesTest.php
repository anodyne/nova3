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
		# code...
	}

	/** @test **/
	public function authorized_users_can_manage_roles()
	{
		# code...
	}

	/** @test **/
	public function a_role_can_be_created()
	{
		# code...
	}

	/** @test **/
	public function a_role_can_be_updated()
	{
		# code...
	}

	/** @test **/
	public function a_role_can_be_deleted()
	{
		# code...
	}
}
