<?php

declare(strict_types=1);

namespace Nova\Setup\Actions;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateNova
{
    use AsAction;

    public string $commandSignature = 'nova:update';

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
    }

    public function asCommand(Command $command): void
    {
        $this->handle();

        $command->info('Nova has been updated!');
    }
}
