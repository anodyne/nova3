<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Features;

use Closure;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Get;
use Nova\Pages\Enums\BoxShadow;
use Nova\Pages\Enums\Radius;

class CardsFeatureBlock extends FeatureBlock
{
    const component = 'features.cards';

    protected ?string $blockLabel = 'Features - Cards';

    protected string|Closure|null $preview = 'features.cards';

    public function blockSchema(): array
    {
        return [
            Section::make()
                ->heading('Appearance')
                ->description('Customize the appearance of the individual feature grid items')
                ->icon(iconName('palette'))
                ->schema([
                    ColorPicker::make('block.heading-color')->label('Heading color'),
                    ColorPicker::make('block.description-color')->label('Description color'),
                    Section::make()
                        ->heading('Card')
                        ->compact()
                        ->columns(2)
                        ->schema([
                            ColorPicker::make('block.card.bg')
                                ->label('Background color')
                                ->rgba()
                                ->columnSpanFull(),
                            Select::make('block.card.radius')
                                ->label('Radius')
                                ->options(Radius::class)
                                ->default(Radius::ExtraLarge->value),
                            Select::make('block.card.shadow')
                                ->label('Shadow')
                                ->options(BoxShadow::class)
                                ->default(BoxShadow::None->value),
                            Select::make('block.card.image-orientation')
                                ->label('Image orientation')
                                ->options([
                                    'top' => 'Top',
                                    'bottom' => 'Bottom',
                                ])
                                ->columnSpanFull(),
                            ToggleButtons::make('block.card.border.enabled')
                                ->label('Use border around card')
                                ->options([
                                    'yes' => 'Yes',
                                    'no' => 'No',
                                ])
                                ->inline()
                                ->live(),
                            ColorPicker::make('block.card.border.color')
                                ->label('Border color')
                                ->rgba()
                                ->visible(fn (Get $get): bool => $get('block.card.border.enabled') == 'yes'),
                        ]),
                ]),
            Section::make()
                ->heading('Grid rows and columns')
                ->description('Customize the number of rows and columns in the grid')
                ->icon(iconName('table'))
                ->schema([
                    Repeater::make('block.rows')->schema([
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
                                    ->disk('media-pages')
                                    ->directory((string) $this->getPageDesignerPage()),
                            ]),
                    ]),
                ]),
        ];
    }
}
