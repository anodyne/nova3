<?php

class SetupControllerTest extends TestCase {

	public function test_homepage_redirects_to_setup_when_not_installed()
	{
		$this->call('GET', '/');
		$this->assertRedirectedToRoute('setup.env');
	}

	public function test_env_redirects_to_setup_when_no_issues()
	{
		$this->route('GET', 'setup.env');
		$this->assertRedirectedToRoute('setup.home');
	}

	public function test_env_shows_issues()
	{
		$this->route('GET', 'setup.env');
		$this->assertRedirectedToRoute('setup.home');
	}

}
