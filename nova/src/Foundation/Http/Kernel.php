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
		\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
		\Illuminate\Cookie\Middleware\EncryptCookies::class,
		\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
		\Illuminate\Session\Middleware\StartSession::class,
		\Illuminate\View\Middleware\ShareErrorsFromSession::class,
		Middleware\VerifyCsrfToken::class,
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth'				=> Middleware\Authenticate::class,
		'auth.basic'		=> \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
		'nova.installed'	=> Middleware\CheckInstallationStatus::class,
		'nova.render'		=> Middleware\RenderController::class,
		'guest'				=> Middleware\RedirectIfAuthenticated::class,
	];

	public function handle($request)
	{
		return parent::handle($request);
	}

}
