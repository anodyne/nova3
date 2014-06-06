<?php namespace Nova\Aegis;

use Illuminate\Support\ServiceProvider;

class AegisServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->registerPersistence();
		$this->registerAegis();
	}

	public function boot()
	{
		//
	}

	protected function registerPersistence()
	{
		$this->registerSession();
		$this->registerCookie();

		$this->app['nova.aegis.persistence'] = $this->app->share(function($app)
		{
			return new Persistence\AegisPersistence($app['nova.aegis.session'], $app['nova.aegis.cookie']);
		});
	}

	protected function registerSession()
	{
		$this->app['nova.aegis.session'] = $this->app->share(function($app)
		{
			$key = 'nova_aegis';

			return new Sessions\IlluminateSession($app['session.store'], $key);
		});
	}

	protected function registerCookie()
	{
		$this->app['nova.aegis.cookie'] = $this->app->share(function($app)
		{
			$key = 'nova_aegis';

			return new Cookies\IlluminateCookie($app['request'], $app['cookie'], $key);
		});
	}

	protected function registerAegis()
	{
		$this->app['nova.aegis'] = $this->app->share(function($app)
		{
			$aegis = new Aegis(
				$app['nova.aegis.persistence']
			);
		});
	}

}