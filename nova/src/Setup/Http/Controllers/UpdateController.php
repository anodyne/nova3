<?php namespace Nova\Setup\Http\Controllers;

use Event,
	Artisan,
	Exception,
	SystemRepositoryContract;
use Spatie\Backup\Events\{BackupHasFailed, BackupWasSuccessful};
use Spatie\Backup\Tasks\Backup\BackupJobFactory;

#TODO: during the update process, re-generate the app key for security purposes

class UpdateController extends BaseController {

	protected $backupStatus;
	protected $backupStatusMessage;
	protected $updateStatus;
	protected $targetVersion;
	protected $currentVersion = '3.0.8';

	public function __construct(SystemRepositoryContract $sysinfo)
	{
		parent::__construct();
		
		$this->sysinfo = $sysinfo;
	}

	public function index()
	{
		return view('pages.setup.update.landing');
	}

	public function backup()
	{
		return view('pages.setup.update.backup');
	}

	public function backupFailed()
	{
		return view('pages.setup.update.backup-failed')
			->with('errorMessage', $this->backupStatusMessage);
	}

	public function backupSuccess()
	{
		return view('pages.setup.update.backup-success')
			->with('errorMessage', $this->backupStatusMessage);
	}

	public function runBackup()
	{
		try
		{
			$backupJob = BackupJobFactory::createFromArray(config('laravel-backup'));
			$backupJob->run();
		}
		catch (Exception $ex)
		{
			return $ex;
		}

		// Run the migrate commands
		$backup = Artisan::call('backup:run');

		$me = $this;

		Event::listen('Spatie\Backup\Events\BackupHasFailed', function ($ex) use (&$me)
		{
			$me->backupStatus = 'failed';
			//$me->backupStatusMessage = "Your database couldn't be backed up. Don't worry though, we've backed up your files and saved them as a zip file on the server.";
			$me->backupStatusMessage = $ex->getMessage();
			\Log::error('BackupHasFailed');
		});

		Event::listen(BackupWasSuccessful::class, function () use (&$me)
		{
			$me->backupStatus = 'success';
			\Log::error('BackupWasSuccessful');

			// Cache the routes in production
			if (app('env') == 'production')
			{
				Artisan::call('route:cache');
			}
		});

		/*if ($this->backupStatus != 'success')
		{
			return redirect()->route('setup.update.backup.failed')
				->with('errorMessage', $this->backupStatusMessage);
		}
		
		return redirect()->route('setup.update.backup.success');*/
	}

	public function changes()
	{
		// Get the release notes to display
		$releases = nova()->getReleaseNotes();

		return view('pages.setup.update.changes', compact('releases'));
	}
}
