<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Hero;

class StackedHeroBlock extends HeroBlock
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->label('Hero - Stacked')
            ->identifier('hero-stacked')
            ->optionsModal(Settings\StackedHeroBlockSettings::class)
            ->renderedView('pages.pages.blocks.hero.stacked')
            ->editorView('pages.pages.blocks.hero.stacked-preview');
    }
}
