<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Hero;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class SimpleCenteredBlock extends HeroBlock
{
    public ?string $label = 'Hero - Simple Centered';

    public string $preview = 'pages.pages.blocks.hero.simple-centered-preview';

    public string $rendered = 'pages.pages.blocks.hero.simple-centered';

    public function getFormSchema(): array
    {
        return array_merge(parent::getFormSchema(), [
            Section::make('Callout')->schema([
                TextInput::make('calloutText'),
                TextInput::make('calloutLinkLabel'),
                TextInput::make('calloutLinkUrl')
                    ->label('Callout link URL')
                    ->url(),
            ]),
            Section::make('Colors')->schema([
                ColorPicker::make('color1')->label('Color 1'),
                ColorPicker::make('color2')->label('Color 2'),
            ]),
            FileUpload::make('image')
                ->disk('media')
                ->directory('pages'),
            Toggle::make('dark'),
        ]);
    }
}
