<?php namespace Nova\Setup\Http\Controllers;

use Cache,
	Artisan,
	Redirect;

class InstallController extends Controller {

	public function index()
	{
		return view('pages.setup.install.landing');
	}

	public function install()
	{
		// Run the migrate commands
		Artisan::call('migrate', ['--force' => true]);

		// Set the installed cache item
		Cache::forever('nova.installed', (bool) true);

		return Redirect::route('setup.install.nova.success');
	}

	public function success()
	{
		return view('pages.setup.install.success');
	}

}
