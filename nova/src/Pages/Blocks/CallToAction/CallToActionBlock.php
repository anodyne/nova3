<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\CallToAction;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\ScribbleTool;

abstract class CallToActionBlock extends ScribbleTool
{
    protected function baseConfiguration(): self
    {
        return $this
            ->icon('tabler-speakerphone')
            ->type(ToolType::Block);
    }
}
