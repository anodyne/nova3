<?php namespace Nova\Foundation\Http;

use Nova\Foundation\Http\Middleware;
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
		Middleware\VerifyCsrfToken::class,
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth'				=> Middleware\Authenticate::class,
		'auth.basic'		=> 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
		'nova.installed'	=> Middleware\CheckInstallationStatus::class,
		'nova.render'		=> Middleware\ProcessController::class,
		'guest'				=> Middleware\RedirectIfAuthenticated::class,
	];

	public function handle($request)
	{
		return parent::handle($request);
	}

}
