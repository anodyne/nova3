<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Hero;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;

class SplitWithOffsetImageHeroBlock extends HeroBlock
{
    public ?string $label = 'Hero - Split w/ offset image';

    public string $rendered = 'pages.pages.blocks.hero.split-with-offset-image';

    public string $preview = 'pages.pages.blocks.hero.split-with-offset-image';

    public function getFormSchema(): array
    {
        return [
            ...parent::getFormSchema(),
            FileUpload::make('image')
                ->disk('media')
                ->directory('pages'),
            Toggle::make('dark')->label('Invert text colors for dark backgrounds'),
        ];
    }
}
