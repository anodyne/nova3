<?php

declare(strict_types=1);

namespace Nova\Setup\Providers;

use BladeUI\Icons\Console\CacheCommand;
use Filament\Support\Colors\ColorManager;
use Livewire\Commands\DiscoverCommand;
use Livewire\Livewire;
use Nova\DomainServiceProvider;
use Nova\Foundation\Colors\Color;
use Nova\Foundation\Nova;
use Nova\Setup\Actions\SeedRealStories;
use Nova\Setup\Actions\SetDatabaseInitialState;
use Nova\Setup\Livewire\ConfigureDatabase;
use Nova\Setup\Livewire\InstallNova;
use Nova\Setup\Livewire\MigrateNovaData;
use Nova\Setup\Livewire\Migrations;
use Nova\Setup\Livewire\SetupAccount;
use Nova\Setup\Livewire\UpdateNova;
use Nova\Setup\Livewire\UserAccess;
use Nova\Setup\View\Components\SetupLayout;
use TimoKoerber\LaravelOneTimeOperations\Commands\OneTimeOperationsProcessCommand;

class SetupServiceProvider extends DomainServiceProvider
{
    public function bladeComponents(): array
    {
        return [
            'setup-layout' => SetupLayout::class,
        ];
    }

    public function domainBooted(): void
    {
        Livewire::forceAssetInjection();

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
            // SeedRealStories::class,
            // DiscoverCommand::class, // Livewire only registers this in the console
            CacheCommand::class, // Blade Icons only registers this in the console
            OneTimeOperationsProcessCommand::class, // One-time Operations package only registers this in the console
            // SetDatabaseInitialState::class,
        ];
    }

    public function livewireComponents(): array
    {
        return [
            'setup-install-nova' => InstallNova::class,
            'setup-migrate-steps' => MigrateNovaData::class,
            'setup-configure-database' => ConfigureDatabase::class,
            'setup-user-account' => SetupAccount::class,
            'setup-user-access' => UserAccess::class,

            'setup-update-nova' => UpdateNova::class,

            'setup-migrate-users' => Migrations\MigrateUsers::class,
            'setup-migrate-user-form' => Migrations\MigrateUserForm::class,
            'setup-migrate-departments' => Migrations\MigrateDepartments::class,
            'setup-migrate-positions' => Migrations\MigratePositions::class,
            'setup-migrate-characters' => Migrations\MigrateCharacters::class,
            'setup-migrate-character-form' => Migrations\MigrateCharacterForm::class,
            'setup-migrate-applications' => Migrations\MigrateApplications::class,
            'setup-migrate-mission-groups' => Migrations\MigrateMissionGroups::class,
            'setup-migrate-missions' => Migrations\MigrateMissions::class,
            'setup-migrate-posts' => Migrations\MigratePosts::class,
            'setup-migrate-personal-logs' => Migrations\MigratePersonalLogs::class,
            'setup-migrate-news-items' => Migrations\MigrateNewsItems::class,
            'setup-migrate-private-messages' => Migrations\MigratePrivateMessages::class,
        ];
    }

    public function routes(): ?string
    {
        return nova_path('setup/routes.php');
    }
}
