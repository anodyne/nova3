<?php namespace Nova\Setup\Http\Controllers;

use Illuminate\Console\Application as Artisan;

#TODO: during the update process, re-generate the app key for security purposes

class UpdateController extends Controller
{
	public function index()
	{
		// Is there an update available for Nova?
		$hasUpdate = nova()->hasUpdate();

		// If there is an update available, grab the info
		$update = ($hasUpdate) ? nova()->getLatestVersion() : false;

		return view('setup.update.landing', compact('hasUpdate', 'update'));
	}

	public function changes()
	{
		// Get the release notes to display
		$releases = nova()->getReleaseNotes();

		return view('setup.update.changes', compact('releases'));
	}

	public function update()
	{
		$update = nova()->getLatestVersion();

		return view('setup.update.run', compact('update'));
	}

	public function updateSuccess()
	{
		return view('setup.update.run-success');
	}

	public function updateFailed()
	{
		return view('setup.update.run-failed')
			->with('errorMessage', session()->get('updateStatusMessage'));
	}

	public function runUpdate(Artisan $artisan)
	{
		// Run the migrate commands
		$artisan->call('migrate', ['--force' => true]);

		// Update the system version in the database
		// $sysinfo->setVersionNumber(config('nova.app.version.full'));

		// Do some cleanup
		$artisan->call('view:clear');
		$artisan->call('cache:clear');
		$artisan->call('auth:clear-resets');

		// Cache the routes in production
		if (app('env') == 'production') {
			$artisan->call('route:cache');
		}
	}
}
