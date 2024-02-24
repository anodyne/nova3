<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Features;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Nova\Pages\Blocks\FormSchema;

class GridFeatureBlock extends FeatureBlock
{
    public ?string $label = 'Features - Grid';

    public string $rendered = 'pages.pages.blocks.features.grid';

    public string $preview = 'pages.pages.blocks.features.grid';

    public function getFormSchema(): array
    {
        return [
            ...parent::getFormSchema(),
            ...FormSchema::background(),
            ...FormSchema::dark(),
            Section::make('Features')->schema([
                Repeater::make('features')->schema([
                    TextInput::make('heading'),
                    Textarea::make('description'),
                    TextInput::make('icon')
                        ->helperText('You have access to the full Tabler icon set for these icons'),
                ]),
            ]),
        ];
    }
}
