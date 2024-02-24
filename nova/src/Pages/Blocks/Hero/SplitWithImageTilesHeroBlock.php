<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Hero;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Nova\Pages\Blocks\FormSchema;

class SplitWithImageTilesHeroBlock extends HeroBlock
{
    public ?string $label = 'Hero - Split w/ image tiles';

    public string $rendered = 'pages.pages.blocks.hero.split-with-image-tiles';

    public string $preview = 'pages.pages.blocks.hero.split-with-image-tiles-preview';

    public function getFormSchema(): array
    {
        return [
            ...parent::getFormSchema(),
            ...FormSchema::background(),
            Section::make('Image Tiles')->schema([
                Repeater::make('images')
                    ->maxItems(5)
                    ->deletable(false)
                    ->schema([
                        FileUpload::make('image')
                            ->disk('media')
                            ->directory('pages'),
                    ]),
                Radio::make('orientation')
                    ->options([
                        'right' => 'Right',
                        'left' => 'Left',
                    ])
                    ->default('right'),
            ]),
            Toggle::make('dark')->label('Invert text colors for dark backgrounds'),
        ];
    }
}
