<?php

use Illuminate\Foundation\Testing\WithoutMiddleware,
	Illuminate\Foundation\Testing\DatabaseMigrations,
	Illuminate\Foundation\Testing\DatabaseTransactions;

class HomeControllerTest extends TestCase {

	public function setUp()
	{
		parent::setUp();

		//$this->artisan('nova:refresh');
	}

	public function tearDown()
	{
		//$this->artisan('migrate:reset');

		parent::tearDown();
	}

	public function test_main_page_displays()
	{
		$this->visit('/')
			->see('USS Nova');
	}

}
