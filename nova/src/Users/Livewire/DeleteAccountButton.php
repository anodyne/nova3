<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Nova\Users\Models\User;
use Nova\Users\Notifications\UserDeletedAccount;

class DeleteAccountButton extends Component
{
    public User $user;

    public function delete(): void
    {
        $this->authorize('delete', $this->user);

        Notification::send(
            User::whereHasPermission('character.update')->get(),
            new UserDeletedAccount(user: $this->user)
        );

        auth()->logout();

        redirect()
            ->route('home')
            ->notify('Your user account has been deleted');
    }

    public function render()
    {
        return view('pages.users.livewire.delete-account-button');
    }
}
