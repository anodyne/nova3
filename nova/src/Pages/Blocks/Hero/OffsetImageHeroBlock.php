<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Hero;

class OffsetImageHeroBlock extends HeroBlock
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->label('Hero - Offset image')
            ->identifier('hero-offset-image')
            ->optionsModal(Settings\OffsetImageHeroBlockSettings::class)
            ->renderedView('pages.pages.blocks.hero.offset-image')
            ->editorView('pages.pages.blocks.hero.offset-image-preview');
    }
}
