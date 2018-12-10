<?php

namespace Nova\Foundation\Providers;

use Nova\Pages\Page;
use Illuminate\Support\ServiceProvider;

class ResponsableServiceProvider extends ServiceProvider
{
	protected $defer = true;

	public function register()
	{
		$this->registerResponseClasses();
	}

	public function provides()
	{
		return $this->getResponsableClasses();
	}

	protected function getResponsableClasses()
	{
		return [
			\Nova\Auth\Http\Responses\SignInResponse::class,
			\Nova\Auth\Http\Responses\RequestPasswordResponse::class,
			\Nova\Auth\Http\Responses\ResetPasswordResponse::class,
			\Nova\Auth\Http\Responses\VerifyEmailResponse::class,

			\Nova\Authorize\Http\Responses\RoleIndexResponse::class,

			\Nova\Dashboard\Http\Responses\DashboardResponse::class,

			\Nova\Themes\Http\Responses\ThemeIndexResponse::class,
		];
	}

	protected function registerResponseClasses()
	{
		collect($this->getResponsableClasses())
			->each(function ($responsable) {
				$this->app->singleton($responsable, function ($app) use ($responsable) {
					$page = optional(request()->route())->findPageFromRoute();

					return new $responsable($page, $app);
				});
			});
	}
}
