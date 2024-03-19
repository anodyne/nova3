<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Logos\Settings;

use Awcodes\Scribble\Enums\SlideDirection;
use Awcodes\Scribble\Livewire\ScribbleModal;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\MaxWidth;
use Nova\Pages\Blocks\FormSchema;

abstract class LogosBlockSettings extends ScribbleModal
{
    protected bool $useOrientation = true;

    public static function getSlideDirection(): SlideDirection
    {
        return SlideDirection::Right;
    }

    public static function getMaxWidth(): MaxWidth
    {
        return MaxWidth::ExtraLarge;
    }

    public function getFormFields(): array
    {
        return [
            ...FormSchema::heading(withOrientation: $this->useOrientation),
            ...FormSchema::backgroundColor(),
            Section::make('Logos')->schema([
                Repeater::make('logos')
                    ->schema([
                        TextInput::make('url')
                            ->label('URL')
                            ->url(),
                        FileUpload::make('image')
                            ->disk('media')
                            ->directory('pages'),
                    ]),
            ]),
        ];
    }
}
