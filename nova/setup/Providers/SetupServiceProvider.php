<?php

declare(strict_types=1);

namespace Nova\Setup\Providers;

use BladeUI\Icons\Console\CacheCommand;
use Filament\Support\Colors\ColorManager;
use Livewire\Commands\DiscoverCommand;
use Nova\DomainServiceProvider;
use Nova\Foundation\Colors\Color;
use Nova\Foundation\Nova;
use Nova\Pages\Enums\PageVerb;
use Nova\Setup\Actions\SeedRealStories;
use Nova\Setup\Controllers\StartSetupController;
use Nova\Setup\Livewire\ConfigureDatabase;
use Nova\Setup\Livewire\InstallNova;
use Nova\Setup\Livewire\MigrateNova;
use Nova\Setup\Livewire\MigrateNovaSteps;
use Nova\Setup\Livewire\Migration\MigrateCharacters;
use Nova\Setup\Livewire\Migration\MigrateDepartments;
use Nova\Setup\Livewire\Migration\MigrateMissions;
use Nova\Setup\Livewire\Migration\MigrateNewsItems;
use Nova\Setup\Livewire\Migration\MigratePersonalLogs;
use Nova\Setup\Livewire\Migration\MigratePositions;
use Nova\Setup\Livewire\Migration\MigratePosts;
use Nova\Setup\Livewire\Migration\MigrateUsers;
use Nova\Setup\Livewire\SetupAccount;
use Nova\Setup\Livewire\UserAccess;

class SetupServiceProvider extends DomainServiceProvider
{
    public function domainBooted(): void
    {
        if (! Nova::isInstalled()) {
            app(ColorManager::class)->register([
                'primary' => Color::Sky,
                'danger' => Color::Rose,
                'success' => Color::Emerald,
                'gray' => Color::Gray,
            ]);
        }
    }

    public function consoleCommands(): array
    {
        return [
            SeedRealStories::class,
            DiscoverCommand::class, // Livewire only registers this in the console
            CacheCommand::class, // Blade Icons only registers this in the console
        ];
    }

    public function livewireComponents(): array
    {
        return [
            'setup-install-nova' => InstallNova::class,
            'setup-migrate-steps' => MigrateNovaSteps::class,
            'setup-configure-database' => ConfigureDatabase::class,
            'setup-user-account' => SetupAccount::class,

            'setup-migrate-users' => MigrateUsers::class,
            'setup-migrate-characters' => MigrateCharacters::class,
            'setup-migrate-missions' => MigrateMissions::class,
            'setup-migrate-posts' => MigratePosts::class,
            'setup-migrate-logs' => MigratePersonalLogs::class,
            'setup-migrate-news' => MigrateNewsItems::class,
            'setup-migrate-departments' => MigrateDepartments::class,
            'setup-migrate-positions' => MigratePositions::class,
        ];
    }

    public function routes(): array
    {
        return [
            'setup' => [
                'verb' => PageVerb::get->value,
                'uses' => StartSetupController::class,
            ],

            'setup/configure-database' => [
                'verb' => PageVerb::get->value,
                'uses' => ConfigureDatabase::class,
            ],

            'setup/install' => [
                'verb' => PageVerb::get->value,
                'uses' => InstallNova::class,
            ],

            'setup/migrate' => [
                'verb' => PageVerb::get->value,
                'uses' => MigrateNova::class,
            ],
            'setup/migrate/configure-database' => [
                'verb' => PageVerb::get->value,
                'uses' => ConfigureDatabase::class,
            ],
            'setup/migrate/steps' => [
                'verb' => PageVerb::get->value,
                'uses' => MigrateNovaSteps::class,
            ],
            'setup/migrate/set-user-access' => [
                'verb' => PageVerb::get->value,
                'uses' => UserAccess::class,
            ],

            'setup/user-account' => [
                'verb' => PageVerb::get->value,
                'uses' => SetupAccount::class,
            ],
        ];
    }
}
