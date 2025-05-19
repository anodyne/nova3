<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Nova\Setup\Enums\SetupType;

#[Layout('layouts.setup', ['type' => SetupType::Migrate])]
class MigrateNovaData extends Component
{
    public bool $isFinished = false;

    public bool $isRunning = false;

    public array $errors = [];

    public array $migrators = [
        Migrations\MigrateUsers::class,
        Migrations\MigrateUserForm::class,
        Migrations\MigrateDepartments::class,
        Migrations\MigratePositions::class,
        Migrations\MigrateCharacters::class,
        Migrations\MigrateCharacterForm::class,
        Migrations\MigrateApplications::class,
        Migrations\MigrateMissionGroups::class,
        Migrations\MigrateMissions::class,
        Migrations\MigratePosts::class,
        Migrations\MigratePersonalLogs::class,
        Migrations\UpdatePostOrdering::class,
        Migrations\MigrateNewsItems::class,
        Migrations\MigratePrivateMessages::class,
        Migrations\MigrateSettings::class,
        Migrations\MigrateBans::class,
    ];

    public int $currentStep = 0;

    public float $startTime = 0;

    public float $endTime = 0;

    public function startMigration(): void
    {
        Cache::forget('migration_complete');

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

        Cache::put('migration_complete', true, Date::now()->addHour());
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
