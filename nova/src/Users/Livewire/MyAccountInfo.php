<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Illuminate\Support\Facades\Notification as NotificationFacade;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Users\Actions\DeleteAccount;
use Nova\Users\Models\User;
use Nova\Users\Notifications\UserDeletedAccount;

class MyAccountInfo extends Component
{
    public MyAccountInfoForm $form;

    public function delete(): void
    {
        $this->authorize('deleteAccount', $user = auth()->user());

        DeleteAccount::run($user);

        NotificationFacade::send(
            User::whereHasPermission('character.update')->get(),
            new UserDeletedAccount(user: $user)
        );

        auth()->logout();

        redirect('/')->notify('Your user account has been deleted');
    }

    public function save(): void
    {
        $this->authorize('update', auth()->user());

        $this->form->save();

        Notification::make()->success()
            ->title('Account updated')
            ->send();
    }

    #[Computed]
    public function errors()
    {
        return $this->getErrorBag();
    }

    public function mount(): void
    {
        $this->form->setAccount(auth()->user());
    }

    public function render()
    {
        return view('pages.users.livewire.my-account-info', [
            'errors' => $this->errors,
        ]);
    }
}
