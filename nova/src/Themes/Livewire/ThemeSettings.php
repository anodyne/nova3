<?php

declare(strict_types=1);

namespace Nova\Themes\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Themes\Data\ThemeSettings as ThemeSettingsData;
use Nova\Themes\Models\Theme;

class ThemeSettings extends Component implements HasForms
{
    use InteractsWithForms;

    public array $fonts = [];

    public ?array $data = [];

    public ?Theme $theme = null;

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->theme->themeClass()->settingsForm())
            ->statePath('data')
            ->model($this->theme);
    }

    public function fontUpdated(array $data = []): void
    {
        $type = $data['type'];

        $this->fonts["{$type}Provider"] = $data['provider'];
        $this->fonts["{$type}Family"] = $data['family'];
    }

    public function save(): void
    {
        $settings = ThemeSettingsData::from([
            'fonts' => $this->fonts,
            'settings' => $this->form->getState(),
        ]);

        $this->theme->update(['settings' => $settings]);

        $this->dispatch('theme-settings-close');

        Notification::make()->success()
            ->title('Theme settings have been updated')
            ->send();
    }

    public function mount(Theme $theme): void
    {
        $this->fonts = $theme->settings->fonts->toArray();
        $this->form->fill($theme->settings->settings);
    }

    public function render()
    {
        return view('pages.themes.livewire.theme-settings');
    }
}
