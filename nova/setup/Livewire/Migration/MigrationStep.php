<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migration;

use Livewire\Component;

abstract class MigrationStep extends Component
{
    public string $label;

    public bool $isFinished = false;

    public bool $isRunning = false;

    public bool $shouldMigrate = true;

    protected $listeners = ['startMigrationStep'];

    abstract public function getPendingMigrationCountProperty(): int;

    abstract public function getCompletedMigrationCountProperty(): int;

    abstract public function runMigrationStep(): void;

    public function getWasSuccessfullyMigratedProperty(): bool
    {
        return $this->pendingMigrationCount === $this->completedMigrationCount;
    }

    public function getMigrationCountBadgeColorProperty(): string
    {
        return match (true) {
            $this->isFinished && $this->wasSuccessfullyMigrated => 'success',
            $this->isFinished && ! $this->wasSuccessfullyMigrated => 'danger',
            default => 'gray',
        };
    }

    public function startMigrationStep(array $payload): void
    {
        if (data_get($payload, 'step') === static::class) {
            if ($this->shouldMigrate) {
                $this->isRunning = true;
            }

            $this->dispatch('run-migration-step', id: $this->id());
        }
    }

    public function migrate(): void
    {
        if ($this->shouldMigrate) {
            $this->runMigrationStep();
        }

        $this->startNextMigration();
    }

    public function startNextMigration(): void
    {
        $migrationEventMap = [
            MigrateUsers::class => MigrateDepartments::class,
            MigrateDepartments::class => MigratePositions::class,
            MigratePositions::class => MigrateCharacters::class,
            MigrateCharacters::class => MigrateMissions::class,
            MigrateMissions::class => MigratePosts::class,
            MigratePosts::class => MigratePersonalLogs::class,
            MigratePersonalLogs::class => MigrateNewsItems::class,
        ];

        $this->isRunning = false;
        $this->isFinished = true;

        if ($receiver = data_get($migrationEventMap, static::class)) {
            $this->dispatch('startMigrationStep', ['step' => $receiver]);
        } else {
            $this->dispatch('finishMigration');
        }
    }

    public function mount()
    {
        if ($this->wasSuccessfullyMigrated) {
            $this->shouldMigrate = false;
        }
    }

    public function render()
    {
        return view('setup.migrate-nova.steps.step', [
            'pendingMigrationCount' => $this->pendingMigrationCount,
            'completedMigrationCount' => $this->completedMigrationCount,
            'migrationCountBadgeColor' => $this->migrationCountBadgeColor,
            'wasSuccessfullyMigrated' => $this->wasSuccessfullyMigrated,
        ]);
    }
}
