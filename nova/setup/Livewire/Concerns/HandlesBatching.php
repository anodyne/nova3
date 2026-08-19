<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Concerns;

use Illuminate\Bus\Batch;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Config;
use Livewire\Attributes\Computed;

trait HandlesBatching
{
    public ?string $batchId = null;

    public int $batchProgress = 0;

    abstract protected function getBatchJobs(): Collection;

    public function updateBatchProgress(): void
    {
        if ($this->isBatchable()) {
            $this->batchProgress = $this->batch->progress();

            if ($this->batchProgress >= 100) {
                $this->isRunning = false;
                $this->isFinished = true;

                $this->dispatch('migrationStepFinished');
            }
        }
    }

    #[Computed]
    public function batch(): ?Batch
    {
        if (is_null($this->batchId)) {
            return null;
        }

        return Bus::findBatch($this->batchId);
    }

    protected function handleMigrationBatch(): void
    {
        $batch = Bus::batch($this->getBatchJobs())
            ->allowFailures()
            ->dispatch();

        $this->batchId = $batch->id;
    }

    protected function isBatchable(): bool
    {
        return Config::get('queue.default') !== 'sync';
    }
}
