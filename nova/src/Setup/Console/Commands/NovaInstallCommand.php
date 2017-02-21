<?php namespace Nova\Setup\Console\Commands;

use Artisan, Storage;
use Illuminate\Console\Command;
use Illuminate\Filesystem\FilesystemManager;
use Symfony\Component\Console\Input\{InputOption, InputArgument};

class NovaInstallCommand extends Command {

	protected $name = 'nova:install';
	protected $description = 'Install the Nova database schema';
	protected $files;

	public function __construct(FilesystemManager $storage)
	{
		parent::__construct();
		
		$this->files = $storage->disk('local');
	}

	public function handle()
	{
		$this->call('migrate', ['--force' => true]);

		// Get an instance of the writer
		$writer = app('nova.setup.configWriter');

		// Generate the new key
		$newKey = 'base64:'.base64_encode(random_bytes(
			config('app.cipher') == 'AES-128-CBC' ? 16 : 32
		));

		// Write the app config file
		$writer->write('app', [
			'#APP_KEY#' => $newKey,
		]);

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
