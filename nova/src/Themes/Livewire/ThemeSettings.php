<?php

declare(strict_types=1);

namespace Nova\Themes\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\SlideOver;
use Nova\Themes\Data\ThemeSettings as ThemeSettingsData;
use Nova\Themes\Models\Theme;

/**
 * @property-read Schema $form
 */
class ThemeSettings extends SlideOver implements HasForms
{
    use InteractsWithForms;

    public array $fonts = [];

    public ?array $data = [];

    public string|Theme $theme;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components($this->theme->themeClass()->settingsForm())
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
        $themeSettings = ThemeSettingsData::from([
            'fonts' => $this->fonts,
            'settings' => $this->form->getState(),
        ]);

        $this->theme->update(['settings' => $themeSettings]);

        $this->close();

        Notification::make()->success()
            ->title('Theme settings have been updated')
            ->send();
    }

    public function mount(string $theme): void
    {
        $this->theme = Theme::location($theme)->first();

        $this->fonts = $this->theme->settings->fonts->toArray();
        $this->form->fill($this->theme->settings->settings);
    }

    public function render(): Factory|View
    {
        return view('pages.themes.livewire.theme-settings');
    }
}
