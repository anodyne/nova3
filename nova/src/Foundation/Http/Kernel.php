<?php namespace Nova\Foundation\Http;

use Nova\Foundation\Http\Middleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * These middleware are run during every request to your application.
	 *
	 * @var array
	 */
	protected $middleware = [
		\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
	];

	/**
	 * The application's route middleware groups.
	 *
	 * @var array
	 */
	protected $middlewareGroups = [
		'web' => [
			Middleware\EncryptCookies::class,
			\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
			\Illuminate\Session\Middleware\StartSession::class,
			\Illuminate\View\Middleware\ShareErrorsFromSession::class,
			\Illuminate\Routing\Middleware\SubstituteBindings::class,
			Middleware\VerifyCsrfToken::class,
		],
		'api' => [
			'throttle:60,1',
			'bindings',
		],
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' => Middleware\Authenticate::class,
		'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
		'guest' => Middleware\RedirectIfAuthenticated::class,
		'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
		'can' => \Illuminate\Auth\Middleware\Authorize::class,
		'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
		
		'nova.installed' => Middleware\CheckInstallationStatus::class,
		'nova.render' => Middleware\RenderController::class,
	];

	public function handle($request)
	{
		return parent::handle($request);
	}

}
