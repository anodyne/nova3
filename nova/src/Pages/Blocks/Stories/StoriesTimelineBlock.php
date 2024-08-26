<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stories;

class StoriesTimelineBlock extends StoriesBlock
{
    protected function setUp(): void
    {
        $this->baseConfiguration()
            ->label('Stories - Timeline')
            ->identifier('stories-timeline-block')
            ->optionsModal(Settings\StoriesTimelineBlockSettings::class)
            ->renderedView('pages.pages.blocks.stories.timeline')
            ->editorView('pages.pages.blocks.stories.timeline-preview');
    }
}
