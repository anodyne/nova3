<?php namespace Nova\Core\Commands;

use Eloquent;
use SystemRoute;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RefreshRoutes extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'nova:routes';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Refresh the routes from the data migration file.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		// Clear out the system routes table
		SystemRoute::where('name', '!=', '')->delete();

		// Grab the routes data file
		$routes = include SRCPATH.'Setup/database/migrations/data/routes.php';

		Eloquent::unguard();

		// Loop through the routes data file and insert the records
		foreach ($routes as $r)
		{
			SystemRoute::create($r);
		}

		// Re-cache the routes
		SystemRoute::cache();

		$this->info('Routes refreshed!');
	}

}