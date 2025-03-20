<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Migrations;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Nova\Setup\Livewire\Concerns\HandlesBatching;
use Nova\Setup\Livewire\Concerns\HandlesDates;
use Throwable;

abstract class MigrationStep extends Component
{
    use HandlesBatching;
    use HandlesDates;

    public string $label;

    public array $errors = [];

    public int $progress = 0;

    public bool $isFinished = false;

    public bool $isRunning = false;

    public bool $canDisableMigration = true;

    public bool $shouldMigrate = true;

    public ?string $noteMessageLangKey = null;

    abstract public function pendingMigrationCount(): int;

    abstract public function completedMigrationCount(): int;

    abstract public function handleMigration(): void;

    public function noteMessage(): ?string
    {
        if (blank($this->noteMessageLangKey)) {
            return null;
        }

        return str(__($this->noteMessageLangKey))->inlineMarkdown()->toString();
    }

    public function migrate(): void
    {
        if (! $this->shouldMigrate || $this->isFinished) {
            $this->dispatch('migrationStepFinished');

            return;
        }

        $this->isRunning = true;

        try {
            if ($this->isBatchable()) {
                $this->handleMigrationBatch();
            } else {
                $this->handleMigration();
            }

            $this->isRunning = false;
            $this->isFinished = true;

            $this->dispatch('migrationStepFinished');
        } catch (Throwable $th) {
            $this->isRunning = false;

            $this->errors[] = $th->getMessage();

            report($th);

            $this->dispatch('migrationError', step: $this->label, message: $th->getMessage());
        }
    }

    public function mount(): void
    {
        if ($this->pendingMigrationCount > 0 && $this->wasSuccessfullyMigrated) {
            $this->shouldMigrate = false;
        }
    }

    public function render(): View
    {
        return view('setup.migrate-nova.steps.step', [
            'pendingMigrationCount' => $this->pendingMigrationCount,
            'completedMigrationCount' => $this->completedMigrationCount,
            'migrationCountBadgeColor' => $this->migrationCountBadgeColor,
            'wasSuccessfullyMigrated' => $this->wasSuccessfullyMigrated,
            'noteMessage' => $this->noteMessage(),
            'isBatchable' => $this->isBatchable(),
        ]);
    }

    #[Computed]
    public function migrationCountBadgeColor(): string
    {
        return match (true) {
            $this->isFinished && $this->wasSuccessfullyMigrated => 'success',
            $this->isFinished && ! $this->wasSuccessfullyMigrated && filled($this->batchId) => 'warning',
            $this->isFinished && ! $this->wasSuccessfullyMigrated => 'danger',
            default => 'gray',
        };
    }

    #[Computed]
    public function wasSuccessfullyMigrated(): bool
    {
        return $this->completedMigrationCount >= $this->pendingMigrationCount;
    }

    #[On('startMigrationStep')]
    public function startMigrationStep(string $step): void
    {
        if ($step !== get_class($this)) {
            return;
        }

        if ($this->shouldMigrate) {
            $this->isRunning = true;
        }

        $this->dispatch('run-migration-step', id: $this->getId());
    }
}
