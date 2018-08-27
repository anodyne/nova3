<?php

namespace Nova\Foundation\Providers;

use Nova\Pages\Page;
use Illuminate\Support\ServiceProvider;

class ResponsableServiceProvider extends ServiceProvider
{
	protected $defer = true;

	public function register()
	{
		collect($this->getResponsableClasses())->each(function ($responsable) {
			$this->app->singleton($responsable, function ($app) use ($responsable) {
				return new $responsable($app['nova.theme'], Page::first());
			});
		});
	}

	public function provides()
	{
		return $this->getResponsableClasses();
	}

	protected function getResponsableClasses()
	{
		return [
			\Nova\Authorize\Http\Responses\RoleIndexResponse::class,

			\Nova\Themes\Http\Responses\ThemeIndexResponse::class,
		];
	}
}
