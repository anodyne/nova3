<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stories;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\ScribbleTool;

abstract class StoriesBlock extends ScribbleTool
{
    protected function baseConfiguration(): self
    {
        return $this
            ->icon('tabler-books')
            ->type(ToolType::Block);
    }
}
