<?php

declare(strict_types=1);

namespace Nova\Settings\Livewire;

use Livewire\Component;
use Nova\Foundation\Filament\Notifications\Notification;

class PostingActivitySettings extends Component
{
    public PostingActivitySettingsForm $form;

    public function save(): void
    {
        $this->authorize('update', settings());

        $this->form->save();

        Notification::make()->success()
            ->title('Posting activity settings updated')
            ->send();
    }

    public function mount()
    {
        $this->form->loadSettings();
    }

    public function render()
    {
        return view('pages.settings.livewire.posting-activity-settings');
    }
}
