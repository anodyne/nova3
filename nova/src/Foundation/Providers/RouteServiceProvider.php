<?php namespace Nova\Foundation\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
	protected $namespace = false;

	public function boot()
	{
		//

		parent::boot();
	}

	public function map()
	{
		$this->mapApiRoutes();

		$this->mapWebRoutes();

		$this->mapOverrideRoutes();
	}

	protected function mapWebRoutes()
	{
		Route::middleware('web')
			->namespace($this->namespace)
			->group(base_path('nova/routes/web.php'));
	}

	protected function mapApiRoutes()
	{
		Route::prefix('api')
			->middleware('api')
			->namespace($this->namespace)
			->group(base_path('nova/routes/api.php'));
	}

	protected function mapOverrideRoutes()
	{
		Route::middleware('web')
			->group(base_path('routes.php'));
	}
}
