<?php namespace Nova\Aegis;

use Illuminate\Support\ServiceProvider;

class AegisServiceProvider extends ServiceProvider {

	protected $defer = true;

	public function boot()
	{
		//
	}

	public function register()
	{
		$this->registerPersistence();
		$this->registerUsers();
		$this->registerAegis();
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
			$key = $app['config']['aegis::session'];

			return new Sessions\IlluminateSession($app['session.store'], $key);
		});
	}

	protected function registerCookie()
	{
		$this->app['nova.aegis.cookie'] = $this->app->share(function($app)
		{
			$key = $app['config']['aegis::cookie'];

			return new Cookies\IlluminateCookie($app['request'], $app['cookie'], $key);
		});
	}

	protected function registerUsers()
	{
		$this->registerHasher();

		$this->app['nova.aegis.users'] = $this->app->share(function($app)
		{
			$model = $app['config']['aegis::users.model'];

			$groups = $app['config']['aegis::groups.model'];
			if (class_exists($groups) && method_exists($groups, 'setUsersModel'))
			{
				forward_static_call_array([$groups, 'setUsersModel'], [$model]);
			}

			return new IlluminateUserRepository($app['nova.aegis.hasher'], $model);
		});
	}

	protected function registerHasher()
	{
		$this->app['nova.aegis.hasher'] = $this->app->share(function($app)
		{
			return new Hashing\NativeHasher;
		});
	}

	protected function registerAegis()
	{
		$this->app['nova.aegis'] = $this->app->share(function($app)
		{
			$aegis = new Aegis(
				$app['nova.aegis.persistence'],
				$app['nova.aegis.users'],
				$app['events']
			);
		});
	}

}