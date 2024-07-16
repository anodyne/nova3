<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Foundation\Filament\Notifications\Notification;

class MyAccount extends Component
{
    public MyAccountForm $form;

    public function save(): void
    {
        $this->authorize('updateAccount', auth()->user());

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

    #[Computed]
    public function timezones()
    {
        return collect(json_decode(file_get_contents(nova_path('timezones.json'))));
    }

    public function mount(): void
    {
        $this->form->setAccount(auth()->user());
    }

    public function render()
    {
        return view('pages.users.livewire.my-account', [
            'errors' => $this->errors,
        ]);
    }
}
