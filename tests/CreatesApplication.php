<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\IconsManifest;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\CachedState;
use Illuminate\Foundation\Testing\WithCachedConfig;
use Illuminate\Foundation\Testing\WithCachedRoutes;
use LivewireUI\Spotlight\Spotlight;

trait CreatesApplication
{
    public function createApplication(): Application
    {
        static $cachedIconsManifest;

        Spotlight::$commands = [];

        $app = require __DIR__.'/../nova/bootstrap/app.php';

        $app->booting(function () use ($app, &$cachedIconsManifest): void {
            $cachedIconsManifest ??= $app->make(IconsManifest::class);

            $app->instance(IconsManifest::class, $cachedIconsManifest);
        });

        $traitsUsedByTest = class_uses_recursive(static::class);

        if (isset(CachedState::$cachedConfig, $traitsUsedByTest[WithCachedConfig::class])) {
            $this->markConfigCached($app);
        }

        if (isset(CachedState::$cachedRoutes, $traitsUsedByTest[WithCachedRoutes::class])) {
            $app->booting(fn () => $this->markRoutesCached($app));
        }

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
