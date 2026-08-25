<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Nova\Foundation\Filament\Notifications\Notification;

/**
 * @property-read MessageBag $errors
 * @property-read Collection<string, mixed> $timezones
 */
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
    public function errors(): MessageBag
    {
        return $this->getErrorBag();
    }

    /** @return Collection<string, mixed> */
    #[Computed]
    public function timezones(): Collection
    {
        $contents = file_get_contents(nova_path('timezones.json'));

        if ($contents === false) {
            return collect();
        }

        $timezones = json_decode($contents);

        return collect(is_object($timezones) ? get_object_vars($timezones) : []);
    }

    public function mount(): void
    {
        $this->form->setAccount(Auth::user());
    }

    public function render(): Factory|View
    {
        return view('pages.users.livewire.my-account', [
            'errors' => $this->errors,
            'timezones' => $this->timezones,
        ]);
    }

    #[On('croppedImageReady')]
    public function handleCroppedImage(?string $path): void
    {
        $this->form->setProfilePhoto($path);
    }
}
