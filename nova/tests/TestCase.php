<?php

namespace Tests;

use RolesSeeder;
use PermissionsSeeder;
use Nova\Foundation\Providers\AuthServiceProvider;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
	use CreatesApplication, ManagesTestUsers;

	protected function setUp()
	{
		parent::setUp();

		$this->artisan('db:seed', ['--class' => PermissionsSeeder::class]);
		$this->artisan('db:seed', ['--class' => RolesSeeder::class]);

		$this->defineAuthorizationGates();
	}

	protected function defineAuthorizationGates()
	{
		return (new AuthServiceProvider(app()))->defineGates();
	}
}
