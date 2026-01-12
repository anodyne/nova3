<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Hero;

use Anodyne\TablerIcons\Tabler;
use Closure;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Nova\Menus\Enums\LinkTarget;
use Nova\Pages\Blocks\Block as PageBuilderBlock;
use Nova\Pages\Enums\BoxShadow;
use Nova\Pages\Enums\ButtonDecoration;
use Nova\Pages\Enums\ButtonSize;
use Nova\Pages\Enums\Radius;

abstract class HeroBlock extends PageBuilderBlock
{
    protected string|Closure $section = 'Hero';

    protected function buttonsRepeater(): array
    {
        return [
            Section::make()
                ->heading('Buttons')
                ->description('Customize any buttons you want displayed in the block')
                ->icon(Tabler::Click)
                ->schema([
                    Repeater::make('block.buttons')
                        ->hiddenLabel()
                        ->maxItems(3)
                        ->schema([
                            Grid::make(3)->schema([
                                TextInput::make('text')
                                    ->label('Button text')
                                    ->columnSpan(2),
                                Select::make('decoration')
                                    ->options(ButtonDecoration::class)
                                    ->default(ButtonDecoration::None),
                            ]),
                            Grid::make(3)->schema([
                                TextInput::make('url')->label('URL')->columnSpan(2),
                                Select::make('url-target')
                                    ->label('Target')
                                    ->options(LinkTarget::class)
                                    ->default(LinkTarget::Self->value),
                            ]),
                            Grid::make(2)->schema([
                                ColorPicker::make('bg-color')->label('Background color')->rgba(),
                                ColorPicker::make('text-color')->label('Text color')->rgba(),
                            ]),
                            Grid::make(2)
                                ->schema([
                                    ToggleButtons::make('border-style')
                                        ->label('Border style')
                                        ->options([
                                            'none' => 'No border',
                                            'outer' => 'Outside',
                                            'inner' => 'Inside',
                                        ])
                                        ->inline()
                                        ->default('none')
                                        ->live(),
                                    ColorPicker::make('border-color')
                                        ->label('Border color')
                                        ->rgba()
                                        ->hidden(fn (Get $get): bool => $get('border-style') === 'none'),
                                ]),
                            Grid::make(3)->schema([
                                Select::make('shadow')
                                    ->label('Shadow')
                                    ->options(BoxShadow::class)
                                    ->default(BoxShadow::None->value),
                                Select::make('radius')
                                    ->label('Corner radius')
                                    ->options(Radius::class)
                                    ->default(Radius::None->value),
                                Select::make('size')
                                    ->label('Button size')
                                    ->options(ButtonSize::class)
                                    ->default(ButtonSize::Large->value),
                            ]),
                        ]),
                ]),
        ];
    }
}
