<?php namespace Nova\Foundation\Console\Commands;

use Illuminate\Foundation\Console\RouteCacheCommand as IlluminateRouteCaching;

class RouteCacheCommand extends IlluminateRouteCaching {

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		if ($this->laravel->environment() == 'production')
		{
			parent::fire();
		}
		else
		{
			$this->info("Routes cannot be cached during development.");
		}
	}

	/**
	 * Boot a fresh copy of the application and get the routes.
	 *
	 * @return \Illuminate\Routing\RouteCollection
	 */
	protected function getFreshApplicationRoutes()
	{
		$app = require $this->laravel['path.base'].'/nova/bootstrap/app.php';

		$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

		return $app['router']->getRoutes();
	}

}
