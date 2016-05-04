<?php namespace Nova\Foundation\Console\Commands;

use File, Cache, Artisan, Storage;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class NovaUninstallCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'nova:uninstall';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Remove Nova entirely';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$this->info("Clearing the cache...");
		Cache::flush();

		if (Storage::disk('local')->has('installed.json'))
		{
			Storage::disk('local')->delete('installed.json');
		}

		$this->info("Removing cached routes...");
		Artisan::call('route:clear');

		$this->info("Removing the database...");
		Artisan::call('migrate:reset', ['--force' => true]);

		$this->info("Removing generated config files...");
		File::delete(app('path.config').'/app.php');
		File::delete(app('path.config').'/database.php');
		File::delete(app('path.config').'/mail.php');
		File::delete(app('path.config').'/services.php');
		File::delete(app('path.config').'/session.php');

		// Remove the SQLite database if it's there
		if (File::exists(config('database.connections.sqlite.database')))
		{
			$this->info("Removing SQLite database file...");
			File::delete(config('database.connections.sqlite.database'));
		}

		$this->info("");
		$this->info(config('nova.app.name').' has been uninstalled!');
		$this->info("");
	}

}
