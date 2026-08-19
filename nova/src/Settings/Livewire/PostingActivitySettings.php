<?php

declare(strict_types=1);

namespace Nova\Settings\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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

    public function mount(): void
    {
        $this->form->loadSettings();
    }

    public function render(): Factory|View
    {
        return view('pages.settings.livewire.posting-activity-settings');
    }
}
