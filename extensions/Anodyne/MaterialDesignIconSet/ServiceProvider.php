<?php

namespace Extensions\Anodyne\MaterialDesignIconSet;

use BladeUI\Icons\Factory;
use Nova\Foundation\Icons\IconSets;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        $set = new MaterialDesignIconSet;

        $this->app->make(Factory::class)->add($set->prefix(), [
            'path' => __DIR__ . '/icons',
            'prefix' => $set->prefix(),
            'class' => 'fill-current',
        ]);

        $this->app->make(IconSets::class)->add($set->prefix(), $set);
    }
}
