<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Features;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\ScribbleTool;

abstract class FeatureBlock extends ScribbleTool
{
    protected function baseConfiguration(): self
    {
        return $this
            ->icon('tabler-sparkles')
            ->type(ToolType::Block);
    }
}
