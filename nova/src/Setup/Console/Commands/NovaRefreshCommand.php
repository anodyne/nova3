<?php namespace Nova\Setup\Console\Commands;

use File;
use Illuminate\Console\Command;
use Illuminate\Filesystem\FilesystemManager;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class NovaRefreshCommand extends Command {

	protected $name = 'nova:refresh';
	protected $description = 'Refresh the Nova installation';
	protected $files;

	public function __construct(FilesystemManager $storage)
	{
		parent::__construct();
		
		$this->files = $storage->disk('local');
	}

	public function handle()
	{
		$this->info("");
		$this->info("Removing cached routes...");
		$this->call('route:clear');

		$this->info("Clearing the cache...");

		if ($this->files->has('installed.json'))
		{
			$this->files->delete('installed.json');
		}

		$this->info("Removing generated config files...");
		File::delete(app('path.config').'/session.php');

		$this->info("Removing the database...");
		$this->call('migrate:reset', ['--force' => true]);

		$this->info("Installing ".config('nova.app.name')."...");
		$this->call('migrate', ['--force' => true]);
		$this->files->put('installed.json', json_encode(['installed' => true]));

		// Grab the data from the setup file
		$data = require_once base_path('_setup.php');

		$this->info("Creating user & character accounts...");
		app('nova.user.creator')->createWithCharacter($data);

		$this->info("Updating settings table...");
		app('SettingRepository')->updateByKey($data['settings']);

		$this->info("Updating page content table...");
		app('PageContentRepository')->updateByKey($data['content']);

		$this->info("");
		$this->info(config('nova.app.name').' has been refreshed!');
		$this->info("");
	}
}
