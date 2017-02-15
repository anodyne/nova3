<?php namespace Nova\Setup\Console\Commands;

use Artisan;
use Illuminate\Console\Command;
use Illuminate\Filesystem\FilesystemManager;
use Symfony\Component\Console\Input\{InputOption, InputArgument};

class NovaInstallCommand extends Command {

	protected $name = 'nova:install';
	protected $description = 'Install the Nova database schema';
	protected $files;

	public function FunctionName(FilesystemManager $storage)
	{
		parent::__construct();
		
		$this->files = $storage->disk('local');
	}

	public function handle()
	{
		$this->call('migrate', ['--force' => true]);

		$this->files->put('installed.json', json_encode(['installed' => true]));

		if (app('env') == 'production')
		{
			$this->call('route:cache');
		}

		$this->info("");
		$this->info(config('nova.app.name').' database schema has been installed!');
		$this->info("");
	}
}
