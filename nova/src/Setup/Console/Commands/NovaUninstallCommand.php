<?php namespace Nova\Setup\Console\Commands;

use File;
use Illuminate\Console\Command;
use Illuminate\Filesystem\FilesystemManager;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class NovaUninstallCommand extends Command
{
	protected $name = 'nova:uninstall';
	protected $description = 'Remove Nova entirely';
	protected $files;

	public function __construct(FilesystemManager $storage)
	{
		parent::__construct();
		
		$this->files = $storage->disk('local');
	}

	public function handle()
	{
		$this->info("Clearing the cache...");
		cache()->flush();

		if ($this->files->has('installed.json')) {
			$this->files->delete('installed.json');
		}

		$this->info("Removing cached routes...");
		$this->call('route:clear');

		$this->info("Removing the database...");
		$this->call('migrate:reset', ['--force' => true]);

		$this->info("Removing generated config files...");
		File::delete(app('path.config').'/app.php');
		File::delete(app('path.config').'/database.php');
		File::delete(app('path.config').'/mail.php');
		File::delete(app('path.config').'/services.php');
		File::delete(app('path.config').'/session.php');

		// Remove the SQLite database if it's there
		if (File::exists(config('database.connections.sqlite.database'))) {
			$this->info("Removing SQLite database file...");
			File::delete(config('database.connections.sqlite.database'));
		}

		$this->info("");
		$this->info(config('nova.app.name').' has been uninstalled!');
		$this->info("");
	}
}
