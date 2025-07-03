<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stories;

use Closure;
use Nova\Pages\Blocks\Block as PageBuilderBlock;

abstract class StoriesBlock extends PageBuilderBlock
{
    protected string|Closure $section = 'Stories';
}
