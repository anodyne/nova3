<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Livewire\Attributes\Locked;
use Livewire\Component;
use Nova\Users\Actions\DeactivateUser;
use Nova\Users\Events\UserDeactivated;
use Nova\Users\Models\User;

class DeactivateUserButton extends Component
{
    #[Locked]
    public User $user;

    public function deactivate(): void
    {
        $this->authorize('deactivate', $this->user);

        DeactivateUser::run($this->user);

        UserDeactivated::dispatch($this->user);

        redirect()
            ->route('admin.users.edit', $this->user)
            ->notify("{$this->user->name} was deactivated");
    }

    public function render()
    {
        return <<<'blade'
            <x-button type="button" color="neutral" wire:click="deactivate">Deactivate</x-button>
        blade;
    }
}
