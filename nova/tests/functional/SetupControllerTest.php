<?php

class SetupControllerTest extends TestCase {

	public function test_homepage_redirects_to_setup_when_not_installed()
	{
		$this->visit('/')
			->see('Fresh Install');
	}

	public function test_env_redirects_to_setup_when_no_issues()
	{
		$this->route('get', 'setup.env');
		$this->assertRedirectedToRoute('setup.home');
	}

}
