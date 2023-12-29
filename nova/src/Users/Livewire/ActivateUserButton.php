<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Livewire\Component;
use Nova\Users\Actions\ActivateUser;
use Nova\Users\Events\UserActivated;
use Nova\Users\Models\User;

class ActivateUserButton extends Component
{
    public User $user;

    public function activate(): void
    {
        $this->authorize('activate', $this->user);

        ActivateUser::run($this->user);

        UserActivated::dispatch($this->user);

        redirect()
            ->route('users.edit', $this->user)
            ->notify("{$this->user->name} was activated");
    }

    public function render()
    {
        return <<<'blade'
            <x-button type="button" color="neutral" wire:click="activate">Activate</x-button>
        blade;
    }
}
