<?php

declare(strict_types=1);

namespace Nova\Settings\Livewire;

use Anodyne\TablerIcons\Tabler;
use Nova\Foundation\Filament\Actions\Action;
use Nova\Foundation\Filament\Notifications\Notification;
use Nova\Foundation\Livewire\SlideOver;

class ThemeBuilder extends SlideOver
{
    public string $primary;

    public string $danger;

    public string $info;

    public string $success;

    public string $warning;

    public string $gray;

    public function isOutOfBounds($color): bool
    {
        $inBoundsColors = $this->getInBoundsColorsFor($color);

        if (count($inBoundsColors) === 0) {
            return false;
        }

        return ! in_array($this->{$color}, $inBoundsColors);
    }

    public function save(): void
    {
        $settings = settings('appearance');

        $newSettings = $settings->with(
            colorsPrimary: $this->primary,
            colorsDanger: $this->danger,
            colorsInfo: $this->info,
            colorsSuccess: $this->success,
            colorsWarning: $this->warning,
            colorsGray: $this->gray,
        );

        settings()->update(['appearance' => $newSettings]);

        $this->dispatch('modal-close');

        Notification::make()->success()
            ->title('Theme settings updated')
            ->body('You‘ll need to refresh the page in order for any themes changes to take effect.')
            ->actions([
                Action::make('refresh')
                    ->color('gray')
                    ->icon(Tabler::Reload)
                    ->url(route('admin.settings.appearance.edit')),
            ])
            ->send();
    }

    public function updatedPrimary($value): void
    {
        $recs = data_get($this->pairings(), $value);

        $this->gray = data_get($recs, 'gray');
        $this->danger = data_get($recs, 'danger');
        $this->info = data_get($recs, 'info');
        $this->success = data_get($recs, 'success');
        $this->warning = data_get($recs, 'warning');
    }

    public function mount()
    {
        $this->primary = settings('appearance.colorsPrimary');
        $this->danger = settings('appearance.colorsDanger');
        $this->info = settings('appearance.colorsInfo');
        $this->success = settings('appearance.colorsSuccess');
        $this->warning = settings('appearance.colorsWarning');
        $this->gray = settings('appearance.colorsGray');
    }

    public function render()
    {
        return view('pages.settings.livewire.theme-builder', [
            'colors' => $this->colors(),
            'grays' => $this->grays(),
        ]);
    }

    public function getInBoundsColorsFor($color): array
    {
        $inBounds = [
            'danger' => [
                'Red',
                'Orange',
                'Rose',
                'Pink',
            ],
            'success' => [
                'Lime',
                'Green',
                'Emerald',
                'Teal',
                'Cyan',
            ],
            'warning' => [
                'Orange',
                'Amber',
                'Yellow',
            ],
        ];

        return data_get($inBounds, $color) ?? [];
    }

    protected function colors(): array
    {
        return [
            'Red',
            'Orange',
            'Amber',
            'Yellow',
            'Lime',
            'Green',
            'Emerald',
            'Teal',
            'Cyan',
            'Sky',
            'Blue',
            'Indigo',
            'Violet',
            'Purple',
            'Fuchsia',
            'Pink',
            'Rose',
        ];
    }

    protected function grays(): array
    {
        return [
            'Slate',
            'Gray',
            'Zinc',
            'Neutral',
            'Stone',
        ];
    }

    protected function pairings(): array
    {
        return [
            'Red' => [
                'gray' => 'Zinc',
                'danger' => 'Rose',
                'info' => 'Purple',
                'success' => 'Emerald',
                'warning' => 'Amber',
            ],
            'Orange' => [
                'gray' => 'Neutral',
                'danger' => 'Red',
                'info' => 'Violet',
                'success' => 'Green',
                'warning' => 'Yellow',
            ],
            'Amber' => [
                'gray' => 'Neutral',
                'danger' => 'Rose',
                'info' => 'Purple',
                'success' => 'Emerald',
                'warning' => 'Amber',
            ],
            'Yellow' => [
                'gray' => 'Stone',
                'danger' => 'Rose',
                'info' => 'Purple',
                'success' => 'Emerald',
                'warning' => 'Amber',
            ],
            'Lime' => [
                'gray' => 'Zinc',
                'danger' => 'Rose',
                'info' => 'Purple',
                'success' => 'Emerald',
                'warning' => 'Amber',
            ],
            'Green' => [
                'gray' => 'Zinc',
                'danger' => 'Rose',
                'info' => 'Purple',
                'success' => 'Emerald',
                'warning' => 'Amber',
            ],
            'Emerald' => [
                'gray' => 'Zinc',
                'danger' => 'Rose',
                'info' => 'Purple',
                'success' => 'Emerald',
                'warning' => 'Amber',
            ],
            'Teal' => [
                'gray' => 'Gray',
                'danger' => 'Pink',
                'info' => 'Purple',
                'success' => 'Lime',
                'warning' => 'Amber',
            ],
            'Cyan' => [
                'gray' => 'Gray',
                'danger' => 'Pink',
                'info' => 'Purple',
                'success' => 'Emerald',
                'warning' => 'Amber',
            ],
            'Sky' => [
                'gray' => 'Zinc',
                'danger' => 'Rose',
                'info' => 'Purple',
                'success' => 'Emerald',
                'warning' => 'Amber',
            ],
            'Blue' => [
                'gray' => 'Slate',
                'danger' => 'Red',
                'info' => 'Violet',
                'success' => 'Green',
                'warning' => 'Yellow',
            ],
            'Indigo' => [
                'gray' => 'Slate',
                'danger' => 'Rose',
                'info' => 'Purple',
                'success' => 'Emerald',
                'warning' => 'Amber',
            ],
            'Violet' => [
                'gray' => 'Gray',
                'danger' => 'Rose',
                'info' => 'Purple',
                'success' => 'Emerald',
                'warning' => 'Amber',
            ],
            'Purple' => [
                'gray' => 'Gray',
                'danger' => 'Rose',
                'info' => 'Purple',
                'success' => 'Emerald',
                'warning' => 'Amber',
            ],
            'Fuchsia' => [
                'gray' => 'Zinc',
                'danger' => 'Rose',
                'info' => 'Purple',
                'success' => 'Emerald',
                'warning' => 'Amber',
            ],
            'Pink' => [
                'gray' => 'Zinc',
                'danger' => 'Rose',
                'info' => 'Purple',
                'success' => 'Emerald',
                'warning' => 'Amber',
            ],
            'Rose' => [
                'gray' => 'Zinc',
                'danger' => 'Rose',
                'info' => 'Purple',
                'success' => 'Emerald',
                'warning' => 'Amber',
            ],
        ];
    }
}
