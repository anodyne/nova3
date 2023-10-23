<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Livewire\Component;
use Nova\Users\Actions\DeactivateUser;
use Nova\Users\Models\User;

class DeactivateUserButton extends Component
{
    public User $user;

    public function deactivate(): void
    {
        $this->authorize('deactivate', $this->user);

        DeactivateUser::run($this->user);

        redirect()
            ->route('users.edit', $this->user)
            ->notify("{$this->user->name} was deactivated");
    }

    public function render()
    {
        return <<<'blade'
            <x-button.filled type="button" color="neutral" wire:click="deactivate">Deactivate</x-button.filled>
        blade;
    }
}
