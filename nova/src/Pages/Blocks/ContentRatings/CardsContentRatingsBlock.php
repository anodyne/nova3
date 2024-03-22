<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\ContentRatings;

class CardsContentRatingsBlock extends ContentRatingsBlock
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->label('Content ratings - Cards')
            ->identifier('ratings-cards')
            ->optionsModal(Settings\CardsContentRatingsBlockSettings::class)
            ->renderedView('pages.pages.blocks.content-ratings.cards')
            ->editorView('pages.pages.blocks.content-ratings.cards-preview');
    }
}
