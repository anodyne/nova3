<?php namespace Tests\Auth;

use Tests\DatabaseTestCase;

class PasswordResetTest extends DatabaseTestCase
{
	protected $user;

	public function setUp()
	{
		parent::setUp();

		$this->user = $this->createUser();
	}
}
