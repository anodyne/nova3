<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Hero;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\ScribbleTool;

abstract class HeroBlock extends ScribbleTool
{
    protected function baseConfiguration(): self
    {
        return $this
            ->icon('tabler-star')
            ->type(ToolType::Block);
    }
}
