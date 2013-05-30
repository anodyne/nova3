<?php namespace Nova\Core\Commands;

use SystemRoute;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AddRoute extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'nova:routes:add';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Add a new route to the System Routes table.';

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
		// Add the route
		SystemRoute::create([
			'name'		=> $this->argument('name'),
			'verb'		=> $this->option('verb'),
			'uri'		=> $this->option('uri'),
			'resource'	=> $this->option('resource'),
		]);

		// Recache the routes
		SystemRoute::cache();

		$this->info('Route added!');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['name', InputArgument::REQUIRED, 'The name of the route.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['verb', null, InputOption::VALUE_OPTIONAL, 'The HTTP verb for the route.', 'get'],
			['uri', null, InputOption::VALUE_OPTIONAL, 'The URI the route responds to.', null],
			['resource', null, InputOption::VALUE_OPTIONAL, 'The resource used by the route.', null],
		];
	}

}