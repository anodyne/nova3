<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Foundation\Filament\Notifications\Notification;

class MyAccountPreferences extends Component
{
    public MyAccountPreferencesForm $form;

    public function save(): void
    {
        $this->authorize('update', auth()->user());

        $this->form->save();

        Notification::make()->success()
            ->title('Account preferences updated')
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
        return view('pages.users.livewire.my-account-preferences', [
            'errors' => $this->errors,
        ]);
    }
}
