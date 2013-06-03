<?php

use Mockery as m;
use Nova\Core\Lib\TestCase;

class UserTest extends TestCase {

	public function tearDown()
	{
		m::close();
	}

	// Test relationships

	// Test scopes

	public function testHashesPasswordWhenSet()
	{
		$mock = m::mock('sentry.hasher');
		$mock->shouldReceive('hash')
			->once()
			->andReturn('hashed');
		$this->app->instance('sentry.hasher', $mock);

		$user = new User;
		$user->password = 'foo';

		$this->assertEquals('hashed', $user->password);
	}

	public function testIsAdmin()
	{
		# code...
	}

	public function testAppReviewsAreReturned()
	{
		# code...
	}

	public function testPreferenceItemsAreReturned()
	{
		# code...
	}

	public function testPrimaryCharacterIsReturned()
	{
		# code...
	}

	public function testUpdateStatus()
	{
		# code...
	}

	public function testUpdateUser()
	{
		# code...
	}

	public function testPopulateSession()
	{
		# code...
	}

	public function testCreateUserPreferences()
	{
		# code...
	}

	public function testUserHasAccess()
	{
		# code...
	}

	public function testUserIsAllowedAcceptsArray()
	{
		# code...
	}

	public function testUserIsAllowedRedirectsToLogin()
	{
		# code...
	}

	public function testUserHasLevelReturnsInteger()
	{
		# code...
	}

}