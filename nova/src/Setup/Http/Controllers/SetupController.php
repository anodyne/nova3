<?php namespace Nova\Setup\Http\Controllers;

use Artisan;

class SetupController extends Controller
{
	public function index()
	{
		// Is Nova installed?
		$installed = nova()->isInstalled();

		// Is there an update available for Nova?
		$hasUpdate = nova()->hasUpdate();

		// If there is an update available, grab the info
		$update = ($hasUpdate) ? nova()->getLatestVersion() : false;

		return view('setup.start', compact('installed', 'update', 'hasUpdate'));
	}

	public function environment()
	{
		// Check the environment
		$env = app('nova')->checkEnvironment();

		// If everything checks out, head to the Setup Center
		if ($env->get('passes')) {
			return redirect()->route('setup.home');
		}

		return view('setup.environment', compact('env'));
	}

	public function uninstall()
	{
		Artisan::call('nova:uninstall');

		// Set the flash message
		flash()
			->message(config('nova.app.name')." has been removed!")
			->success();

		return redirect()->route('setup.home');
	}
}
