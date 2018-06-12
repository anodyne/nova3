<?php

namespace Tests;

use Nova\Foundation\Providers\AuthServiceProvider;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
	use CreatesApplication, ManagesUsers;

	protected function setUp()
	{
		parent::setUp();

		$this->defineAuthorizationGates();
	}

	protected function defineAuthorizationGates()
	{
		return (new AuthServiceProvider(app()))->defineGates();
	}
}
