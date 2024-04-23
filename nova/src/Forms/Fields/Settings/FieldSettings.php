<?php

declare(strict_types=1);

namespace Nova\Forms\Fields\Settings;

use Awcodes\Scribble\Enums\SlideDirection;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\MaxWidth;
use Nova\Foundation\Scribble\ScribbleModal;

abstract class FieldSettings extends ScribbleModal
{
    public static function getSlideDirection(): SlideDirection
    {
        return SlideDirection::Right;
    }

    public static function getMaxWidth(): MaxWidth
    {
        return MaxWidth::ExtraLarge;
    }

    public function getFormData(): array
    {
        return [
            'label' => $this->data['label'] ?? null,
            'description' => $this->data['description'] ?? null,
        ];
    }

    public function getFormFields(): array
    {
        return [
            Section::make('Label')->schema([
                TextInput::make('label'),
                Textarea::make('description')->rows(3),
            ]),
        ];
    }
}
