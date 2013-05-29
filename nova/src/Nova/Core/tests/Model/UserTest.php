<?php

use Mockery as m;
use Nova\Core\Lib\TestCase;

class UserTest extends TestCase {

	public function tearDown()
	{
		m::close();
	}

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

}