<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Livewire\Component;
use Nova\Users\Actions\ForcePasswordReset;
use Nova\Users\Models\User;

class ForcePasswordResetButton extends Component
{
    public User $user;

    public function forcePasswordReset(): void
    {
        $this->authorize('force-password-reset', $this->user);

        ForcePasswordReset::run($this->user);

        redirect()
            ->route('users.edit', $this->user)
            ->notify(
                "Password reset initiated for {$this->user->name}",
                'The user will be forced to reset their password the next time they sign in.'
            );
    }

    public function render()
    {
        return <<<'blade'
            <x-button.filled type="button" color="neutral" wire:click="forcePasswordReset">Force password reset</x-button.filled>
        blade;
    }
}
