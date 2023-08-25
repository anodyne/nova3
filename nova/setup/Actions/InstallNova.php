<?php

declare(strict_types=1);

namespace Nova\Setup\Actions;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class InstallNova
{
    use AsAction;

    public string $commandSignature = 'nova:install';

    public function handle(): void
    {
        Artisan::call('migrate:fresh', [
            '--seed' => true,
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
        try {
            Media::get()->each->delete();
        } catch (Throwable $th) {
            // Don't do anything
        }

        $this->handle();

        $command->info('Nova has been refreshed!');
    }
}
