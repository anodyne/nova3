<?php

declare(strict_types=1);

namespace Nova\Setup\Actions;

use Illuminate\Support\Facades\Artisan;
use Nova\Foundation\Actions\Action;
use Nova\Foundation\Actions\RecacheIcons;

class UpdateNova extends Action
{
    public function handle(): void
    {
        Artisan::call('migrate', [
            '--force' => true,
        ]);

        Artisan::call('optimize:clear');
        Artisan::call('package:discover');
        Artisan::call('filament:upgrade');

        Artisan::call('icons:cache');
        Artisan::call('view:cache');

        RecacheIcons::run();
    }
}
