<?php

declare(strict_types=1);

namespace Nova\Themes\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Nova\Themes\Models\Theme;

/**
 * @property-read Collection<int, Theme> $availableThemes
 * @property-read Theme $selectedTheme
 */
class ThemeSelector extends Component
{
    public ?string $selected = null;

    /** @return Collection<int, Theme> */
    #[Computed]
    public function availableThemes(): Collection
    {
        return Theme::active()->get();
    }

    #[Computed]
    public function selectedTheme(): Theme
    {
        return Theme::location($this->selected)->first();
    }

    public function mount(): void
    {
        $this->selected = settings('appearance.theme');
    }

    public function render(): Factory|View
    {
        return view('pages.themes.livewire.theme-selector', [
            'availableThemes' => $this->availableThemes,
            'selectedTheme' => $this->selectedTheme,
        ]);
    }
}
