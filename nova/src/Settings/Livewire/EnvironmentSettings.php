<?php

declare(strict_types=1);

namespace Nova\Settings\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\SlideOver;

class EnvironmentSettings extends SlideOver
{
    public EnvironmentSettingsForm $form;

    public function save(): void
    {
        $this->authorize('update', settings());

        $this->form->save();

        $this->close();

        Notification::make()->success()
            ->title('Environment settings have been updated')
            ->send();
    }

    public function mount(): void
    {
        $this->form->populate();
    }

    public function render(): Factory|View
    {
        return view('pages.settings.livewire.environment-settings');
    }
}
