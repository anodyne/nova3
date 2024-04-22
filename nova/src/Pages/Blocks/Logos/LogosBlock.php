<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Logos;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\ScribbleTool;

abstract class LogosBlock extends ScribbleTool
{
    protected function baseConfiguration(): self
    {
        return $this
            ->icon('tabler-library-photo')
            ->type(ToolType::Block);
    }
}
