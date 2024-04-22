<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Features;

class GridFeatureBlock extends FeatureBlock
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->label('Features - Grid')
            ->identifier('features-grid')
            ->optionsModal(Settings\GridFeatureBlockSettings::class)
            ->renderedView('pages.pages.blocks.features.grid')
            ->editorView('pages.pages.blocks.features.grid-preview');
    }
}
