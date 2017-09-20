<?php namespace Nova\Setup\Http\Controllers;

use Cache;
use Artisan;
use Session;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemManager;

class SetupController extends Controller
{
	public function index()
	{
		// Grab the instance of the Nova class
		$nova = app('nova');

		// Is Nova installed?
		$installed = $nova->isInstalled();

		// Is there an update available for Nova?
		$hasUpdate = $nova->hasUpdate();

		// If there is an update available, grab the info
		$update = ($hasUpdate) ? $nova->getLatestVersion() : false;

		return view('setup.landing', compact('installed', 'update', 'hasUpdate'));
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

	public function uninstall(FilesystemManager $storage, Filesystem $files)
	{
		// Remove the installed file
		$storage->disk('local')->delete('installed.json');

		// Clear the caches
		Cache::flush();
		Session::flush();
		Artisan::call('cache:clear');
		Artisan::call('config:clear');

		// Clear the routes in production
		if (app('env') == 'production') {
			Artisan::call('route:clear');
		}

		// Reset the database
		Artisan::call('migrate:reset', ['--force' => true]);

		// Remove the config files
		$files->delete(app()->configPath('app.php'));
		$files->delete(app()->configPath('database.php'));
		$files->delete(app()->configPath('mail.php'));
		$files->delete(app()->configPath('services.php'));
		$files->delete(app()->configPath('session.php'));

		// Remove the SQLite database if it's there
		if ($files->exists(config('database.connections.sqlite.database'))) {
			$files->delete(config('database.connections.sqlite.database'));
		}

		// Set the flash message
		flash()->success(config('nova.app.name')." has been removed!");

		return redirect()->route('setup.home');
	}
}
