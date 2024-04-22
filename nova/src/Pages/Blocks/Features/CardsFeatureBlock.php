<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Features;

class CardsFeatureBlock extends FeatureBlock
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->label('Features - Cards')
            ->identifier('features-cards')
            ->optionsModal(Settings\CardsFeatureBlockSettings::class)
            ->renderedView('pages.pages.blocks.features.cards')
            ->editorView('pages.pages.blocks.features.cards-preview');
    }
}
