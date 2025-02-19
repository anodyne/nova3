<?php

declare(strict_types=1);

namespace Nova\Settings\Livewire;

use Livewire\Attributes\Locked;
use Livewire\Component;
use Nova\Foundation\Filament\Notifications\Notification;

class ContentRatingsSettings extends Component
{
    #[Locked]
    public string $category;

    public ContentRatingsSettingsForm $form;

    public function save(): void
    {
        $this->authorize('update', settings());

        $this->form->save($this->category);

        Notification::make()->success()
            ->title(ucfirst($this->category).' content ratings have been updated')
            ->send();
    }

    public function mount(): void
    {
        $this->form->setRatings(settings("ratings.{$this->category}"));
    }

    public function render()
    {
        return view('pages.settings.livewire.content-ratings-settings');
    }
}
