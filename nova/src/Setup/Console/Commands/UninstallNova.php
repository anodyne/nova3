<?php namespace Nova\Setup\Console\Commands;

use Artisan;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemManager;

class UninstallNova extends Command
{
	protected $signature = 'nova:uninstall';
	protected $description = 'Uninstall Nova from the database';

	protected $files;
	protected $storage;

	public function __construct(FilesystemManager $storage, Filesystem $files)
	{
		parent::__construct();
		
		$this->storage = $storage;
		$this->files = $files;
	}

	public function handle()
	{
		// Remove the installed file
		$this->storage->disk('local')->delete('installed.json');

		// Clear the caches
		cache()->flush();
		session()->flush();
		$this->call('cache:clear');
		$this->call('config:clear');

		// Clear the routes in production
		if (app('env') == 'production') {
			$this->call('route:clear');
		}

		// Reset the database
		$this->call('migrate:reset', ['--force' => true]);

		// Remove the config files
		$this->files->delete(app()->configPath('app.php'));
		$this->files->delete(app()->configPath('database.php'));
		$this->files->delete(app()->configPath('mail.php'));
		$this->files->delete(app()->configPath('services.php'));
		$this->files->delete(app()->configPath('session.php'));

		// Remove the SQLite database if it's there
		if ($this->files->exists(config('database.connections.sqlite.database'))) {
			$this->files->delete(config('database.connections.sqlite.database'));
		}
	}
}
