<?php namespace nova\core\commands;

use Eloquent;
use SiteContent;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RefreshContent extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'nova:content';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Refresh the content from the data migration file.';

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
		// Clear out the content table
		SiteContent::where('key', '!=', '')->delete();

		// Grab the content data file
		$routes = include SRCPATH.'setup/database/migrations/data/content.php';

		Eloquent::unguard();

		// Loop through the contents data file and insert the records
		foreach ($routes as $r)
		{
			SiteContent::create($r);
		}

		$this->info('Site content refreshed!');
	}

}