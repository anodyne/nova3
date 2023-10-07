<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migration;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

abstract class MigrationStep extends Component
{
    public string $label;

    public bool $isFinished = false;

    public bool $isRunning = false;

    public bool $shouldMigrate = true;

    abstract public function pendingMigrationCount(): int;

    abstract public function completedMigrationCount(): int;

    abstract public function runMigrationStep(): void;

    #[Computed]
    public function wasSuccessfullyMigrated(): bool
    {
        return $this->pendingMigrationCount === $this->completedMigrationCount;
    }

    #[Computed]
    public function migrationCountBadgeColor(): string
    {
        return match (true) {
            $this->isFinished && $this->wasSuccessfullyMigrated => 'success',
            $this->isFinished && ! $this->wasSuccessfullyMigrated => 'danger',
            default => 'gray',
        };
    }

    #[On('startMigrationStep')]
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
