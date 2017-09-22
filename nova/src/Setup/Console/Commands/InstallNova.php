<?php namespace Nova\Setup\Console\Commands;

use Artisan;
use Illuminate\Console\Command;
use Nova\Setup\ConfigFileWriter;
use Illuminate\Filesystem\FilesystemManager;

class InstallNova extends Command
{
	protected $name = 'nova:install';
	protected $description = 'Install the Nova database schema';

	protected $files;
	protected $writer;

	public function __construct(FilesystemManager $storage, ConfigFileWriter $writer)
	{
		parent::__construct();
		
		$this->files = $storage->disk('local');
		$this->writer = $writer;
	}

	public function handle()
	{
		$this->call('migrate', ['--force' => true]);

		// Generate the new key
		$newKey = 'base64:'.base64_encode(random_bytes(
			config('app.cipher') == 'AES-128-CBC' ? 16 : 32
		));

		// Write the app config file
		$this->writer->write('app', [
			'#APP_KEY#' => $newKey,
		]);

		$this->files->put('installed.json', json_encode(['installed' => true]));
		
		if (app('env') == 'production') {
			$this->call('route:cache');
		}
		
		$this->info("");
		$this->info(config('nova.app.name').' database schema has been installed!');
		$this->info("");
	}
}
