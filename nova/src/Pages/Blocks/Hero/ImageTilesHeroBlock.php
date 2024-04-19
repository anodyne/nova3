<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Hero;

class ImageTilesHeroBlock extends HeroBlock
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->label('Hero - Image tiles')
            ->identifier('hero-image-tiles')
            ->optionsModal(Settings\ImageTilesHeroBlockSettings::class)
            ->renderedView('pages.pages.blocks.hero.image-tiles')
            ->editorView('pages.pages.blocks.hero.image-tiles-preview');
    }
}
