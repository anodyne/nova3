<?php

declare(strict_types=1);

namespace Nova\Foundation\Providers;

use Illuminate\Support\ServiceProvider;

class ResponsesServiceProvider extends ServiceProvider
{
    public function register()
    {
        clock()->event('responses service provider register')->color('purple')->begin();

        $this->registerResponseClasses();

        clock()->event('fortify service provider register')->end();
    }

    public function provides()
    {
        return $this->getResponsableClasses();
    }

    protected function getResponsableClasses()
    {
        return [
            \Nova\Foundation\Responses\SimplePageResponse::class,
            \Nova\Foundation\Responses\WelcomePageResponse::class,
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
