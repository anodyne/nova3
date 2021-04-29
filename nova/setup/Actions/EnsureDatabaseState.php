<?php

namespace Nova\Setup\Actions;

use Database\State;
use Illuminate\Console\Command;
use Illuminate\Database\Events\MigrationsEnded;
use Lorisleiva\Actions\Concerns\AsAction;

class EnsureDatabaseState
{
    use AsAction;

    public string $commandSignature = 'nova:ensure-database-state';

    public function handle(): void
    {
        activity()->disableLogging();

        collect([
            new State\EnsureThemesArePresent,
            new State\EnsurePermissionsArePresent,
            new State\EnsureRolesArePresent,
            new State\EnsureRolePermissionsArePresent,
            new State\EnsurePagesArePresent,
            new State\EnsureDefaultSettingsArePresent,
            new State\EnsureCustomSettingsArePresent,
            new State\EnsurePostTypesArePresent,
            new State\EnsureStoryTimelineIsPresent,
        ])->each->__invoke();

        activity()->enableLogging();
    }

    public function asCommand(Command $command): void
    {
        $this->handle();

        $command->info('Database state verified');
    }

    public function asListener(MigrationsEnded $event): void
    {
        $this->handle();
    }
}
