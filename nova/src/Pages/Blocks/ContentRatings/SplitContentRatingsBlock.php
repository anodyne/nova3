<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\ContentRatings;

class SplitContentRatingsBlock extends ContentRatingsBlock
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->label('Content ratings - Split')
            ->identifier('ratings-split')
            ->optionsModal(Settings\SplitContentRatingsBlockSettings::class)
            ->renderedView('pages.pages.blocks.content-ratings.split')
            ->editorView('pages.pages.blocks.content-ratings.split-preview');
    }
}
