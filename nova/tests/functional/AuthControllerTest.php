<?php

use Illuminate\Foundation\Testing\WithoutMiddleware,
	Illuminate\Foundation\Testing\DatabaseMigrations,
	Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthControllerTest extends TestCase {

	public function setUp()
	{
		parent::setUp();

		Artisan::call('nova:refresh');

		$this->refreshApplication();
	}

	public function tearDown()
	{
		Artisan::call('nova:uninstall');

		parent::tearDown();
	}

	public function test_login_page_displays()
	{
		$this->route('get', 'login');
		$this->see('Log In');
	}

}
