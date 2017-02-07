<?php namespace Nova\Setup\Http\Controllers;

use Event,
	Exception,
	SystemRepositoryContract;
use Illuminate\Http\Request;
use Nova\Setup\BackupJobFactory;
use Illuminate\Console\Application as Artisan;

#TODO: during the update process, re-generate the app key for security purposes
#TODO: once the update process is complete, blow away the backupStatus session variable

class UpdateController extends BaseController {

	protected $backupStatus;
	protected $backupStatusMessage;

	public function index()
	{
		// Is there an update available for Nova?
		$hasUpdate = nova()->hasUpdate();

		// If there is an update available, grab the info
		$update = ($hasUpdate) ? nova()->getLatestVersion() : false;

		return view('pages.setup.update.landing', compact('hasUpdate', 'update', 'nova'));
	}

	public function backup()
	{
		return view('pages.setup.update.backup');
	}

	public function backupFailed()
	{
		return view('pages.setup.update.backup-failed')
			->with('errorMessage', session()->get('backupStatusMessage'));
	}

	public function backupSuccess()
	{
		return view('pages.setup.update.backup-success');
	}

	public function runBackup(Request $request)
	{
		try {
			$backupJob = BackupJobFactory::createFromArray(config('laravel-backup'));

			$backupJob->run();

			$request->session()->put('backupStatus', 'success');

			return true;
		}
		catch (Exception $ex) {
			$request->session()->put('backupStatus', 'failed');
			$request->session()->flash('backupStatusMessage', str_replace('\r\n', ' ', $ex->getMessage()));

			throw new Exception(str_replace('\r\n', ' ', $ex->getMessage()));
		}
	}

	public function changes()
	{
		// Get the release notes to display
		$releases = nova()->getReleaseNotes();

		return view('pages.setup.update.changes', compact('releases'));
	}

	public function update()
	{
		$update = nova()->getLatestVersion();

		return view('pages.setup.update.run', compact('update'));
	}

	public function updateSuccess()
	{
		return view('pages.setup.update.run-success');
	}

	public function updateFailed()
	{
		return view('pages.setup.update.run-failed')
			->with('errorMessage', session()->get('updateStatusMessage'));
	}

	public function runUpdate(Artisan $artisan, SystemRepositoryContract $sysinfo)
	{
		// Run the migrate commands
		$artisan->call('migrate', ['--force' => true]);

		// Update the system version in the database
		$sysinfo->setVersionNumber(config('nova.app.version.full'));

		// Do some cleanup
		$artisan->call('view:clear');
		$artisan->call('cache:clear');
		$artisan->call('auth:clear-resets');

		// Cache the routes in production
		if (app('env') == 'production')
		{
			$artisan->call('route:cache');
		}
	}
}
