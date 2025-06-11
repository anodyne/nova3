<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Nova\Foundation\Filament\Notifications\Notification;

class MyAccount extends Component
{
    public MyAccountForm $form;

    public function save(): void
    {
        $this->authorize('updateAccount', Auth::user());

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
        $this->form->setAccount(Auth::user());
    }

    public function render()
    {
        return view('pages.users.livewire.my-account', [
            'errors' => $this->errors,
            'timezones' => $this->timezones,
        ]);
    }

    #[On('croppedImageReady')]
    public function handleCroppedImage($path)
    {
        $this->form->setProfilePhoto($path);
    }
}
