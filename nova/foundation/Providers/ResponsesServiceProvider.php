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
            \Nova\Foundation\Http\Responses\SimplePageResponse::class,
            \Nova\Foundation\Http\Responses\WelcomePageResponse::class,

            \Nova\Auth\Http\Responses\LoginResponse::class,
            \Nova\Auth\Http\Responses\ForgotPasswordResponse::class,
            \Nova\Auth\Http\Responses\ResetPasswordResponse::class,
            \Nova\Auth\Http\Responses\EmailVerificationResponse::class,

            \Nova\Dashboard\Http\Responses\DashboardResponse::class,

            \Nova\Themes\Http\Responses\Index::class,
            \Nova\Themes\Http\Responses\Create::class,
            \Nova\Themes\Http\Responses\Edit::class,

            \Nova\Users\Http\Responses\Index::class,
            \Nova\Users\Http\Responses\Create::class,
            \Nova\Users\Http\Responses\Edit::class,
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
