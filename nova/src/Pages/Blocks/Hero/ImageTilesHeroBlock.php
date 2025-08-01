<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Hero;

use Filament\Schemas\Components\Section;
use Closure;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;

class ImageTilesHeroBlock extends HeroBlock
{
    const component = 'hero.image-tiles';

    protected ?string $blockLabel = 'Hero - Image tiles';

    protected string|Closure|null $preview = 'hero.image-tiles';

    public function blockSchema(): array
    {
        return [
            ...$this->buttonsRepeater(),
            Section::make('block.media')
                ->heading('Media')
                ->description('Customize the media that you want displayed for the block')
                ->icon(iconName('image'))
                ->schema([
                    Repeater::make('block.media.images')
                        ->maxItems(5)
                        ->hiddenLabel()
                        ->schema([
                            FileUpload::make('image')
                                ->disk('media-pages')
                                ->directory((string) $this->getPageDesignerPage())
                                ->image(),
                        ]),
                ]),
        ];
    }
}
