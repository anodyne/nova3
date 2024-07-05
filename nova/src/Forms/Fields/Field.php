<?php

declare(strict_types=1);

namespace Nova\Forms\Fields;

use Awcodes\Scribble\Enums\ToolType;
use Awcodes\Scribble\ScribbleTool;

abstract class Field extends ScribbleTool
{
    protected function baseConfiguration(): self
    {
        return $this->type(ToolType::Block);
    }
}
