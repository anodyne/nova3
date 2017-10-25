<?php namespace Nova\Setup\Console\Commands;

use Artisan;
use Illuminate\Console\Command;
use Nova\Foundation\SystemInfo;
use Nova\Setup\ConfigFileWriter;
use Illuminate\Filesystem\FilesystemManager;

class UpdateNova extends Command
{
	protected $name = 'nova:update';
	protected $description = 'Update Nova to the latest version';

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

		// Update the system version in the database
		SystemInfo::first()->setVersion(config('nova.version'));

		// Generate the new key
		$newKey = 'base64:'.base64_encode(random_bytes(
			config('app.cipher') == 'AES-128-CBC' ? 16 : 32
		));

		// Write the app config file
		$this->writer->update('app', [
			config('app.key') => $newKey,
		]);

		$this->call('view:clear');
		$this->call('cache:clear');
		$this->call('auth:clear-resets');

		if (app('env') == 'production') {
			$this->call('route:cache');
		}

		$this->info(config('nova.app.name').' update completed.');
	}
}
