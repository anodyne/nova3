<?php

namespace Nova\Setup\Listeners;

use Database\State;
use Illuminate\Database\Events\MigrationsEnded;

class EnsureDatabaseStateIsLoaded
{
    public function handle(MigrationsEnded $event)
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
}
