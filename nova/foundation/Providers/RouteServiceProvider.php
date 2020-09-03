<?php

namespace Nova\Foundation\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/dashboard';

    protected $namespace = false;

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAcceptanceTestingRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->group(nova_path('routes/web.php'));
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->group(nova_path('routes/api.php'));
    }

    protected function mapAcceptanceTestingRoutes()
    {
        if ($this->app->environment('acceptance')) {
            Route::prefix('__testing__')
                ->middleware('web')
                ->group(nova_path('routes/testing.php'));
        }
    }
}
