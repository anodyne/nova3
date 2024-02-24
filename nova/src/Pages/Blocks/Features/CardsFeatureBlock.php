<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Features;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Nova\Pages\Blocks\FormSchema;

class CardsFeatureBlock extends FeatureBlock
{
    public ?string $label = 'Features - Cards';

    public string $rendered = 'pages.pages.blocks.features.cards';

    public string $preview = 'pages.pages.blocks.features.cards';

    public function getFormSchema(): array
    {
        return [
            ...parent::getFormSchema(),
            ...FormSchema::backgroundColor(),
            ...FormSchema::dark(),
            Repeater::make('rows')->schema([
                Select::make('layout')
                    ->options([
                        'sm-md' => '1 small column, 1 medium column',
                        'md-sm' => '1 medium column, 1 small column',
                        'sm' => '3 small columns',
                        'lg' => '1 large column',
                    ])
                    ->live(),
                Repeater::make('columns')
                    ->maxItems(fn (Get $get): int => match ($get('layout')) {
                        'lg' => 1,
                        'sm' => 3,
                        default => 2
                    })
                    ->schema([
                        TextInput::make('heading'),
                        Textarea::make('description'),
                        FileUpload::make('image')
                            ->disk('media')
                            ->directory('pages'),
                    ]),
            ]),
        ];
    }
}
