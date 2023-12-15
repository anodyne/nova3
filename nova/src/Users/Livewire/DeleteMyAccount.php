<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Users\Actions\DeleteAccount;
use Nova\Users\Models\User;
use Nova\Users\Notifications\UserDeletedAccount;

class DeleteMyAccount extends Component
{
    public function delete(): void
    {
        $this->authorize('deleteAccount', $user = Auth::user());

        DeleteAccount::run($user);

        Notification::send(
            User::whereHasPermission('user.update')->get(),
            new UserDeletedAccount(user: $user)
        );

        Auth::logout();

        redirect('/')->notify('Your user account has been deleted');
    }

    #[Computed]
    public function errors()
    {
        return $this->getErrorBag();
    }

    public function render()
    {
        return view('pages.users.livewire.delete-my-account', [
            'errors' => $this->errors,
        ]);
    }
}
