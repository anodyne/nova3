<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stats;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\ScribbleTool;

abstract class StatsBlock extends ScribbleTool
{
    protected function baseConfiguration(): self
    {
        return $this
            ->icon('tabler-chart-bar')
            ->type(ToolType::Block);
    }
}
