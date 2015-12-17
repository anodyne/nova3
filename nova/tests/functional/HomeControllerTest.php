<?php

use Illuminate\Foundation\Testing\WithoutMiddleware,
	Illuminate\Foundation\Testing\DatabaseMigrations,
	Illuminate\Foundation\Testing\DatabaseTransactions;

class HomeControllerTest extends TestCase {

	public function setUp()
	{
		parent::setUp();

		Artisan::call('nova:refresh');
	}

	public function tearDown()
	{
		Artisan::call('nova:uninstall');

		parent::tearDown();
	}

	public function test_main_page_displays()
	{
		$this->visit('/')->see('USS Nova');
	}

}
