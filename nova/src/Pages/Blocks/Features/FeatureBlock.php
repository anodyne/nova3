<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Features;

use Closure;
use Nova\Pages\Blocks\Block as PageBuilderBlock;

abstract class FeatureBlock extends PageBuilderBlock
{
    protected string|Closure $section = 'Features';
}
