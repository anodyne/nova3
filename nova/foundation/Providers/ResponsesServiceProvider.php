<?php

namespace Nova\Foundation\Providers;

use Illuminate\Support\ServiceProvider;

class ResponsesServiceProvider extends ServiceProvider
{
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
            \Nova\Foundation\Responses\SimplePageResponse::class,
            \Nova\Foundation\Responses\WelcomePageResponse::class,

            \Nova\Auth\Responses\LoginResponse::class,
            \Nova\Auth\Responses\ForgotPasswordResponse::class,
            \Nova\Auth\Responses\ResetPasswordResponse::class,
            \Nova\Auth\Responses\EmailVerificationResponse::class,

            \Nova\Dashboard\Responses\DashboardResponse::class,
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
