<?php

declare(strict_types=1);

namespace Extensions\Anodyne\BootstrapIconSet;

use BladeUI\Icons\Factory;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Nova\Foundation\Icons\IconSets;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        $set = new BootstrapIconSet;

        $this->app->make(Factory::class)->add($set->prefix(), [
            'path' => __DIR__.'/icons',
            'prefix' => $set->prefix(),
            'class' => 'fill-current',
        ]);

        $this->app->make(IconSets::class)->add($set->prefix(), $set);
    }
}
