<?php namespace nova\extensions\cartalyst\sentry;

use Cartalyst\Sentry\Sentry;
use Illuminate\Support\ServiceProvider;
use Cartalyst\Sentry\Cookies\IlluminateCookie;
use Cartalyst\Sentry\Sessions\IlluminateSession;
use nova\extensions\cartalyst\sentry\hashing\NovaHasher;
use nova\extensions\cartalyst\sentry\users\Provider as UserProvider;
use nova\extensions\cartalyst\sentry\groups\Provider as GroupProvider;
use nova\extensions\cartalyst\sentry\throttling\Provider as ThrottleProvider;

class SentryServiceProvider extends ServiceProvider {

	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('cartalyst/sentry', 'cartalyst/sentry');

		$this->observeEvents();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerHasher();

		$this->registerSession();

		$this->registerCookie();

		$this->registerGroupProvider();

		$this->registerUserProvider();

		$this->registerThrottleProvider();

		$this->registerSentry();
	}

	/**
	 * Register the hasher used by Sentry.
	 *
	 * @return void
	 */
	protected function registerHasher()
	{
		$this->app['sentry.hasher'] = $this->app->share(function($app)
		{
			return new NovaHasher;
		});
	}

	/**
	 * Register the session driver used by Sentry.
	 *
	 * @return void
	 */
	protected function registerSession()
	{
		$this->app['sentry.session'] = $this->app->share(function($app)
		{
			return new IlluminateSession($app['session']);
		});
	}

	/**
	 * Register the cookie driver used by Sentry.
	 *
	 * @return void
	 */
	protected function registerCookie()
	{
		$this->app['sentry.cookie'] = $this->app->share(function($app)
		{
			return new IlluminateCookie($app['cookie']);
		});
	}

	/**
	 * Register the group provider used by Sentry.
	 *
	 * @return void
	 */
	protected function registerGroupProvider()
	{
		$this->app['sentry.group'] = $this->app->share(function($app)
		{
			return new GroupProvider('AccessRole');
		});
	}

	/**
	 * Register the user provider used by Sentry.
	 *
	 * @return void
	 */
	protected function registerUserProvider()
	{
		$this->app['sentry.user'] = $this->app->share(function($app)
		{
			$model = 'User';

			// We will never be accessing a user in Sentry without accessing
			// the user provider first. So, we can lazily setup our user
			// model's login attribute here. If you are manually using the
			// attribute outside of Sentry, you will need to ensure you are
			// overriding at runtime.
			if (method_exists($model, 'setLoginAttribute'))
			{
				$loginAttribute = $app['config']['cartalyst/sentry::sentry.users.login_attribute'];

				forward_static_call_array(
					array($model, 'setLoginAttribute'),
					array($loginAttribute)
				);
			}

			return new UserProvider($app['sentry.hasher'], $model);
		});
	}

	/**
	 * Register the throttle provider used by Sentry.
	 *
	 * @return void
	 */
	protected function registerThrottleProvider()
	{
		$this->app['sentry.throttle'] = $this->app->share(function($app)
		{
			return new ThrottleProvider($app['sentry.user'], 'UserSuspend');
		});
	}

	/**
	 * Takes all the components of Sentry and glues them
	 * together to create Sentry.
	 *
	 * @return void
	 */
	protected function registerSentry()
	{
		$this->app['sentry'] = $this->app->share(function($app)
		{
			// Once the authentication service has actually been requested by the developer
			// we will set a variable in the application indicating such. This helps us
			// know that we need to set any queued cookies in the after event later.
			$app['sentry.loaded'] = true;

			return new Sentry(
				$app['sentry.user'],
				$app['sentry.group'],
				$app['sentry.throttle'],
				$app['sentry.session'],
				$app['sentry.cookie'],
				$app['request']->getClientIp()
			);
		});
	}

	/**
	 * Sets up event observations required by Sentry.
	 *
	 * @return void
	 */
	protected function observeEvents()
	{
		// Set the cookie after the app runs
		$app = $this->app;
		$this->app->after(function($request, $response) use ($app)
		{
			if (isset($app['sentry.loaded']) and $app['sentry.loaded'] == true and ($cookie = $app['sentry.cookie']->getCookie()))
			{
				$response->headers->setCookie($cookie);
			}
		});
	}

}
