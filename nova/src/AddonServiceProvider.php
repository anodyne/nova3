<?php

declare(strict_types=1);

namespace Nova;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

abstract class AddonServiceProvider extends ServiceProvider
{
    protected string $location;

    public function boot(): void {}

    public function register(): void {}

    protected function runMigrations(): void
    {
        Artisan::call('migrate', [
            '--force' => true,
            '--path' => 'addons/'.$this->location.'/Migrations',
        ]);
    }
}
