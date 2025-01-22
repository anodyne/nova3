<?php

declare(strict_types=1);

namespace Nova\Addons\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Nova\Addons\Data\AddonSettings as AddonSettingsData;
use Nova\Addons\Models\Addon;
use Nova\Foundation\Filament\Notifications\Notification;

class AddonSettings extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public ?Addon $addon = null;

    public bool $iconTrigger = true;

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->addon->addonClass()->settingsForm())
            ->statePath('data')
            ->model($this->addon);
    }

    public function save(): void
    {
        $settings = AddonSettingsData::from(
            settings: $this->form->getState()
        );

        $this->addon->update(['settings' => $settings]);

        $this->dispatch('addon-settings-close');

        Notification::make()->success()
            ->title('Add-on settings have been updated')
            ->send();
    }

    public function mount(Addon $addon): void
    {
        $this->form->fill($addon->settings->settings);
    }

    public function render()
    {
        return view('pages.add-ons.livewire.addon-settings');
    }
}
