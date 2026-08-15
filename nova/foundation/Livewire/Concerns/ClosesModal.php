<?php

declare(strict_types=1);

namespace Nova\Foundation\Livewire\Concerns;

trait ClosesModal
{
    /**
     * Close the overlay this component is rendered in, optionally dispatching
     * events to the rest of the page on the way out.
     *
     * @param  array<string, array<int, mixed>>  $andDispatch  Event name => positional payload
     */
    public function close(array $andDispatch = []): void
    {
        foreach ($andDispatch as $event => $parameters) {
            $this->dispatch($event, ...$parameters);
        }

        $this->dispatch('modal-close');
    }
}
