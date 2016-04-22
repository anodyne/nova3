<?php namespace Nova\Foundation\Console\Commands;

use File, Artisan, Storage;
use Nova\Core\Users\Services\UserCreatorService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class NovaRefreshCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'nova:refresh';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Refresh the Nova installation';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$this->info("");
		$this->info("Removing cached routes...");
		Artisan::call('route:clear');

		$this->info("Clearing the cache...");

		if (Storage::disk('local')->has('installed.json'))
		{
			Storage::disk('local')->delete('installed.json');
		}

		$this->info("Removing generated config files...");
		File::delete(app('path.config').'/session.php');

		$this->info("Removing the database...");
		Artisan::call('migrate:reset', ['--force' => true]);

		$this->info("Installing ".config('nova.app.name')."...");
		Artisan::call('migrate', ['--force' => true]);
		Storage::disk('local')->put('installed.json', json_encode(['installed' => true]));

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
