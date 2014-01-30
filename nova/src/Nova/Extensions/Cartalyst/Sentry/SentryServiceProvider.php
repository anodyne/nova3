<?php namespace Nova\Extensions\Cartalyst\Sentry;

use Config;
use Cartalyst\Sentry\Cookies\IlluminateCookie,
	Cartalyst\Sentry\Sessions\IlluminateSession,
	Cartalyst\Sentry\Users\IlluminateUserRepository,
	Cartalyst\Sentry\Groups\IlluminateGroupRepository,
	Cartalyst\Sentry\Laravel\SentryServiceProvider as BaseSentryServiceProvider;

class SentryServiceProvider extends BaseSentryServiceProvider {

	public function boot()
	{
		//$this->package('cartalyst/sentry', 'cartalyst/sentry', __DIR__.'/../../..');
	}

	protected function registerSession()
	{
		$this->app['sentry.session'] = $this->app->share(function($app)
		{
			return new IlluminateSession($app['session.store'], 'cartalyst_sentry');
		});
	}

	protected function registerCookie()
	{
		$this->app['sentry.cookie'] = $this->app->share(function($app)
		{
			return new IlluminateCookie($app['request'], $app['cookie'], 'cartalyst_sentry');
		});
	}

	protected function registerUsers()
	{
		$this->registerHasher();

		$this->app['sentry.users'] = $this->app->share(function($app)
		{
			// Grab the aliases
			$aliases = Config::get('app.aliases');

			// Set the user and group models
			$model = $aliases['UserModel'];
			$groups = $aliases['AccessRoleModel'];

			if (class_exists($groups) and method_exists($groups, 'setUsersModel'))
			{
				forward_static_call_array(array($groups, 'setUsersModel'), array($model));
			}

			return new IlluminateUserRepository($app['sentry.hasher'], $model);
		});
	}

	protected function registerGroups()
	{
		$this->app['sentry.groups'] = $this->app->share(function($app)
		{
			// Grab the aliases
			$aliases = Config::get('app.aliases');

			// Set the user and group models
			$model = $aliases['AccessRoleModel'];
			$users = $aliases['UserModel'];

			if (class_exists($users) and method_exists($users, 'setGroupsModel'))
			{
				forward_static_call_array(array($users, 'setGroupsModel'), array($model));
			}

			return new IlluminateGroupRepository($model);
		});
	}

}