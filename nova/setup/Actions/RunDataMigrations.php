<?php

namespace Nova\Setup\Actions;

use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Support\Facades\Artisan;
use Lorisleiva\Actions\Concerns\AsAction;

class RunDataMigrations
{
    use AsAction;

    public function handle(): void
    {
        activity()->disableLogging();

        Artisan::call('migrate-data');

        activity()->enableLogging();
    }

    public function asListener(MigrationsEnded $event): void
    {
        $this->handle();
    }
}
