<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Content;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\ScribbleTool;

class FreeformContentBlock extends ScribbleTool
{
    protected function setUp(): void
    {
        $this
            ->icon('tabler-text-size')
            ->type(ToolType::Block)
            ->label('Freeform content')
            ->identifier('content')
            ->optionsModal(Settings\FreeformContentBlockSettings::class)
            ->renderedView('pages.pages.blocks.content.index');
    }
}
