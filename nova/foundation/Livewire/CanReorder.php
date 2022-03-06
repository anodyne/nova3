<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire;

trait CanReorder
{
    public bool $reordering = false;

    abstract public function reorder(array $items): void;

    public function startReordering(): void
    {
        $this->reordering = true;
    }

    public function stopReordering(): void
    {
        $this->reordering = false;
    }
}
