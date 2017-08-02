<?php namespace Tests\Users;

use Nova\Users\User;
use Tests\DatabaseTestCase;

class UserTest extends DatabaseTestCase
{
	protected $user;

	public function setUp()
	{
		parent::setUp();

		$this->user = create('Nova\Users\User');
	}
}
