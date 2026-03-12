<?php

declare(strict_types=1);

namespace Nova\Setup\Providers;

use BladeUI\Icons\Console\CacheCommand;
use Filament\Support\Facades\FilamentColor;
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
use Nova\Setup\Livewire\Migrations\MigrateApplications;
use Nova\Setup\Livewire\Migrations\MigrateBans;
use Nova\Setup\Livewire\Migrations\MigrateCharacterForm;
use Nova\Setup\Livewire\Migrations\MigrateCharacters;
use Nova\Setup\Livewire\Migrations\MigrateDepartments;
use Nova\Setup\Livewire\Migrations\MigrateMissionGroups;
use Nova\Setup\Livewire\Migrations\MigrateMissions;
use Nova\Setup\Livewire\Migrations\MigrateNewsItems;
use Nova\Setup\Livewire\Migrations\MigratePersonalLogs;
use Nova\Setup\Livewire\Migrations\MigratePositions;
use Nova\Setup\Livewire\Migrations\MigratePosts;
use Nova\Setup\Livewire\Migrations\MigratePrivateMessages;
use Nova\Setup\Livewire\Migrations\MigrateSettings;
use Nova\Setup\Livewire\Migrations\MigrateUserForm;
use Nova\Setup\Livewire\Migrations\MigrateUsers;
use Nova\Setup\Livewire\Migrations\UpdatePostOrdering;
use Nova\Setup\Livewire\SetupAccount;
use Nova\Setup\Livewire\UpdateNova;
use Nova\Setup\Livewire\UserAccess;
use Nova\Setup\View\Components\SetupLayout;

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
            FilamentColor::register([
                'primary' => Color::Sky,
                'danger' => Color::Rose,
                'gray' => Color::Zinc,
                'info' => Color::Purple,
                'success' => Color::Emerald,
                'warning' => Color::Amber,
            ]);
        }
    }

    public function consoleCommands(): array
    {
        return [
            // SeedRealStories::class,
            // DiscoverCommand::class, // Livewire only registers this in the console
            CacheCommand::class, // Blade Icons only registers this in the console
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

            'setup-migrate-users' => MigrateUsers::class,
            'setup-migrate-user-form' => MigrateUserForm::class,
            'setup-migrate-departments' => MigrateDepartments::class,
            'setup-migrate-positions' => MigratePositions::class,
            'setup-migrate-characters' => MigrateCharacters::class,
            'setup-migrate-character-form' => MigrateCharacterForm::class,
            'setup-migrate-applications' => MigrateApplications::class,
            'setup-migrate-mission-groups' => MigrateMissionGroups::class,
            'setup-migrate-missions' => MigrateMissions::class,
            'setup-migrate-posts' => MigratePosts::class,
            'setup-migrate-personal-logs' => MigratePersonalLogs::class,
            'setup-migrate-news-items' => MigrateNewsItems::class,
            'setup-migrate-private-messages' => MigratePrivateMessages::class,
            'setup-migrate-settings' => MigrateSettings::class,
            'setup-migrate-bans' => MigrateBans::class,
            'setup-update-post-ordering' => UpdatePostOrdering::class,
        ];
    }

    public function routes(): ?string
    {
        return nova_path('setup/routes.php');
    }
}
