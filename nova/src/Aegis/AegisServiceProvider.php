<?php namespace Nova\Aegis;

use Illuminate\Support\ServiceProvider;

class AegisServiceProvider extends ServiceProvider {

	public function boot()
	{
		//
	}

	public function register()
	{
		$this->registerAegis();
	}

	protected function registerAegis()
	{
		$this->app['nova.aegis'] = $this->app->share(function($app)
		{
			return new \Nova\Aegis($app['auth']);
		});
	}

}