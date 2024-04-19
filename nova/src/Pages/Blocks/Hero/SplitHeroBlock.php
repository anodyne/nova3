<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Hero;

class SplitHeroBlock extends HeroBlock
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->label('Hero - Split')
            ->identifier('hero-split')
            ->optionsModal(Settings\SplitHeroBlockSettings::class)
            ->renderedView('pages.pages.blocks.hero.split')
            ->editorView('pages.pages.blocks.hero.split-preview');
    }
}
