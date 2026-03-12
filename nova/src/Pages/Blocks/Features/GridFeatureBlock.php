<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Features;

use Anodyne\TablerIcons\Tabler;
use Closure;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class GridFeatureBlock extends FeatureBlock
{
    const component = 'features.grid';

    protected ?string $blockLabel = 'Features - Grid';

    protected string|Closure|null $preview = 'features.grid';

    public function blockSchema(): array
    {
        return [
            Section::make()
                ->heading('Appearance')
                ->description('Customize the appearance of the individual feature grid items')
                ->icon(Tabler::Palette)
                ->schema([
                    ColorPicker::make('block.heading-color')->label('Heading color'),
                    ColorPicker::make('block.description-color')->label('Description color'),
                    ColorPicker::make('block.icon-color')->label('Icon color'),
                ]),
            Section::make()
                ->heading('Features')
                ->description('Define the features you want to highlight with this block')
                ->icon(Tabler::Sparkles)
                ->schema([
                    Repeater::make('block.features')->schema([
                        TextInput::make('heading'),
                        Textarea::make('description'),
                        Select::make('icon')
                            ->options(Tabler::class)
                            ->searchable(),
                    ]),
                ]),
        ];
    }
}
