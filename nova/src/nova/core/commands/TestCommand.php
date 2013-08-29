<?php namespace nova\core\commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TestCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'nova:test';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Run unit tests for Nova.';

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
		ini_set('error_reporting', E_ALL);
		ini_set('display_errors', (int) true);

		system('nova/vendor/bin/phpunit --testsuite=core');
	}

}