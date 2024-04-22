<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stories;

class AlternatingStoriesBlock extends StoriesBlock
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->label('Stories - Alternating')
            ->identifier('stories-alternating')
            ->optionsModal(Settings\AlternatingStoriesBlockSettings::class)
            ->renderedView('pages.pages.blocks.stories.alternating')
            ->editorView('pages.pages.blocks.stories.alternating-preview');
    }
}
