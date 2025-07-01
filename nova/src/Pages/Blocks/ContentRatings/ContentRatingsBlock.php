<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\ContentRatings;

use Closure;
use Nova\Pages\Blocks\Block as PageBuilderBlock;

abstract class ContentRatingsBlock extends PageBuilderBlock
{
    protected string|Closure $section = 'Content Ratings';
}
