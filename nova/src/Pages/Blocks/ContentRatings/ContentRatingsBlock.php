<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\ContentRatings;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\ScribbleTool;

abstract class ContentRatingsBlock extends ScribbleTool
{
    protected function baseConfiguration(): self
    {
        return $this
            ->icon('tabler-explicit')
            ->type(ToolType::Block);
    }
}
