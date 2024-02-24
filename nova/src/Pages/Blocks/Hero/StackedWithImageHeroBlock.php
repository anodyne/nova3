<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Hero;

use Filament\Forms\Components\Toggle;
use Nova\Pages\Blocks\FormSchema;

class StackedWithImageHeroBlock extends HeroBlock
{
    public ?string $label = 'Hero - Stacked w/ image';

    public string $rendered = 'pages.pages.blocks.hero.stacked-with-image';

    public string $preview = 'pages.pages.blocks.hero.stacked-with-image-preview';

    public function getFormSchema(): array
    {
        return [
            ...parent::getFormSchema(),
            ...FormSchema::background(),
            ...FormSchema::mediaTopBottom(),
            Toggle::make('dark')->label('Invert text colors for dark backgrounds'),
        ];
    }
}
