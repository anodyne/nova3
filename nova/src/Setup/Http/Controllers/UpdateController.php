<?php namespace Nova\Setup\Http\Controllers;

use Artisan;
use Nova\Foundation\SystemInfo;

#TODO: during the update process, re-generate the app key for security purposes

class UpdateController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('nova.auth-setup');
	}

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

	public function runUpdate()
	{
		// Run the update command
		Artisan::call('nova:update');

		// Reset the update phase
		SystemInfo::first()->setPhase('update', 1);
	}
}
