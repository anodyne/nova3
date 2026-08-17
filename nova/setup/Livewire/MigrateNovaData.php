<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Nova\Foundation\Enums\CacheKeys;
use Nova\Setup\Enums\SetupType;
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

/**
 * @property-read float $elapsedTime
 * @property-read bool $hasErrors
 */
#[Layout('layouts.setup', ['type' => SetupType::Migrate])]
class MigrateNovaData extends Component
{
    public bool $isFinished = false;

    public bool $isRunning = false;

    public array $errors = [];

    public array $migrators = [
        MigrateUsers::class,
        MigrateUserForm::class,
        MigrateDepartments::class,
        MigratePositions::class,
        MigrateCharacters::class,
        MigrateCharacterForm::class,
        MigrateApplications::class,
        MigrateMissionGroups::class,
        MigrateMissions::class,
        MigratePosts::class,
        MigratePersonalLogs::class,
        UpdatePostOrdering::class,
        MigrateNewsItems::class,
        MigratePrivateMessages::class,
        MigrateSettings::class,
        MigrateBans::class,
    ];

    public int $currentStep = 0;

    public float $startTime = 0;

    public float $endTime = 0;

    public function startMigration(): void
    {
        Cache::forget(CacheKeys::MigrationComplete->value);

        $this->startTime = microtime(true);

        $this->isRunning = true;
        $this->currentStep = 0;

        $this->dispatch('startMigrationStep', step: $this->migrators[$this->currentStep]);
    }

    public function render()
    {
        return view('setup.migrate-nova.steps.index', [
            'hasErrors' => $this->hasErrors,
            'elapsedTime' => $this->elapsedTime,
        ]);
    }

    #[Computed]
    public function elapsedTime(): float
    {
        return round($this->endTime - $this->startTime, 1);
    }

    #[Computed]
    public function hasErrors(): bool
    {
        return ! empty($this->errors);
    }

    #[On('finishMigration')]
    public function finishMigration(): void
    {
        $this->isRunning = false;
        $this->isFinished = true;

        $this->endTime = microtime(true);

        Cache::put(CacheKeys::MigrationComplete->value, true, Date::now()->addHour());
    }

    #[On('migrationStepFinished')]
    public function handleStepFinished(): void
    {
        $this->currentStep++;

        if ($this->currentStep < count($this->migrators)) {
            $this->dispatch('startMigrationStep', step: $this->migrators[$this->currentStep]);
        } else {
            $this->finishMigration();
        }
    }

    #[On('migrationError')]
    public function recordError(string $step, string $message): void
    {
        $this->errors[] = ['step' => $step, 'message' => $message];
    }
}
