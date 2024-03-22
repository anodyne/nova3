<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\ContentRatings\Settings;

use Awcodes\Scribble\Enums\SlideDirection;
use Awcodes\Scribble\Livewire\ScribbleModal;
use Filament\Support\Enums\MaxWidth;
use Nova\Pages\Blocks\FormSchema;

abstract class ContentRatingsBlockSettings extends ScribbleModal
{
    public static function getSlideDirection(): SlideDirection
    {
        return SlideDirection::Right;
    }

    public static function getMaxWidth(): MaxWidth
    {
        return MaxWidth::ExtraLarge;
    }

    public function mount(): void
    {
        $this->form->fill([
            'heading' => $this->data['heading'] ?? null,
            'description' => $this->data['description'] ?? null,
            'headerOrientation' => $this->data['headerOrientation'] ?? null,

            'bgOption' => $this->data['bgOption'] ?? null,
            'bgColor' => $this->data['bgColor'] ?? null,

            'dark' => $this->data['dark'] ?? false,

            'spacingHorizontal' => $this->data['spacingHorizontal'] ?? null,
            'spacingVertical' => $this->data['spacingVertical'] ?? null,
        ]);
    }

    public function getFormFields(): array
    {
        return [
            ...FormSchema::heading(withOrientation: true),
            ...FormSchema::backgroundColor(),
        ];
    }
}
