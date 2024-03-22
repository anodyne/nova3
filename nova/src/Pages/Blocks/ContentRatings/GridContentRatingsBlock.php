<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\ContentRatings;

class GridContentRatingsBlock extends ContentRatingsBlock
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->label('Content ratings - Grid')
            ->identifier('ratings-grid')
            ->optionsModal(Settings\GridContentRatingsBlockSettings::class)
            ->renderedView('pages.pages.blocks.content-ratings.grid')
            ->editorView('pages.pages.blocks.content-ratings.grid-preview');
    }
}
