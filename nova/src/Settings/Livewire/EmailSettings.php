<?php

declare(strict_types=1);

namespace Nova\Settings\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Media\Enums\ImageAction;

class EmailSettings extends Component
{
    public EmailSettingsForm $form;

    #[On('mediaUploaded')]
    public function handleImagePath($action, $path): void
    {
        $this->form->imageAction = ImageAction::tryFrom($action) ?? ImageAction::Unchanged;
        $this->form->imageTempPath = $path;
    }

    public function save(): void
    {
        $this->authorize('update', settings());

        $this->form->save();

        Notification::make()->success()
            ->title('Email settings have been updated')
            ->send();
    }

    public function mount()
    {
        $this->form->setEmailSettings();
    }

    public function render()
    {
        return view('pages.settings.livewire.email-settings');
    }
}
