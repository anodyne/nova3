<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Hero;

use Filament\Forms\Components\Toggle;
use Nova\Pages\Blocks\FormSchema;

class SplitWithImageHeroBlock extends HeroBlock
{
    public ?string $label = 'Hero - Split w/ image';

    public string $rendered = 'pages.pages.blocks.hero.split-with-block-image';

    public string $preview = 'pages.pages.blocks.hero.split-with-block-image-preview';

    public function getFormSchema(): array
    {
        return [
            ...parent::getFormSchema(),
            ...FormSchema::background(),
            ...FormSchema::mediaLeftRight(),
            Toggle::make('dark')->label('Invert text colors for dark backgrounds'),
        ];
    }
}
