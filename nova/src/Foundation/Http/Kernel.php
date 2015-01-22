<?php namespace Nova\Foundation\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		'Illuminate\Session\Middleware\StartSession',
		'Illuminate\View\Middleware\ShareErrorsFromSession',
		'Illuminate\Foundation\Http\Middleware\VerifyCsrfToken',
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth'			=> 'Nova\Foundation\Http\Middleware\Authenticate',
		'auth.basic'	=> 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
		'guest'			=> 'Nova\Foundation\Http\Middleware\RedirectIfAuthenticated',
		'installed'		=> 'Nova\Foundation\Http\Middleware\Installed',
	];

	public function handle($request)
	{
		$handle = parent::handle($request);

		//$this->app->setDirectoryPermissions();
		//$this->app->buildStorageDirectory();

		return $handle;
	}

}
