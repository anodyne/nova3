<?php

declare(strict_types=1);

namespace Nova\Settings\Livewire;

use Illuminate\Support\Collection;
use LivewireUI\Modal\ModalComponent;

class FindSettingsModal extends ModalComponent
{
    public string $search = '';

    public Collection $settings;

    /**
     * Dismiss the modal.
     */
    public function dismiss(): void
    {
        $this->forceClose()->closeModal();
    }

    /**
     * Get a subset of all settings based on the search.
     */
    public function getFilteredSettingsProperty(): Collection
    {
        return $this->search === ''
            ? collect()
            : $this->settings->filter(fn ($s) => str($s['keywords'])->contains($this->search));
    }

    public function mount()
    {
        $this->settings = $this->settingsMap();
    }

    public function render()
    {
        return view('livewire.settings.find-settings-modal', [
            'filteredSettings' => $this->filteredSettings,
        ]);
    }

    public static function modalMaxWidth(): string
    {
        return 'sm';
    }

    protected function settingsMap(): Collection
    {
        return collect([
            [
                'route' => 'general',
                'name' => 'General Settings',
                'keywords' => '',
            ],
            [
                'route' => 'email',
                'name' => 'Email Settings',
                'keywords' => '',
            ],
            [
                'route' => 'notifications',
                'name' => 'Notification Settings',
                'keywords' => 'discord notification alert group individual email web',
            ],
            [
                'route' => 'posting-activity',
                'name' => 'Posting Activity Settings',
                'keywords' => 'discord posts story words activity monthly tracking author average posting writing',
            ],
            [
                'route' => 'system-defaults',
                'name' => 'System Defaults Settings',
                'keywords' => 'presentation theme skin pulsar titan icon fluent rating language sex violence swearing look xtras',
            ],
            [
                'route' => 'characters',
                'name' => 'Character Settings',
                'keywords' => 'character creation create link approval limit position availability',
            ],
            [
                'route' => 'meta-tags',
                'name' => 'Meta Tags Settings',
                'keywords' => '',
            ],
        ]);
    }
}
