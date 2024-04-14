<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Features;

class AlternatingFeatureBlock extends FeatureBlock
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->label('Features - Alternating')
            ->identifier('features-alternating')
            ->optionsModal(Settings\AlternatingFeatureBlockSettings::class)
            ->renderedView('pages.pages.blocks.features.alternating')
            ->editorView('pages.pages.blocks.features.alternating-preview');
    }
}
