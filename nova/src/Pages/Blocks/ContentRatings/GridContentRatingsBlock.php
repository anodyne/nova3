<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\ContentRatings;

use Closure;

class GridContentRatingsBlock extends ContentRatingsBlock
{
    const component = 'content-ratings.grid';

    protected ?string $blockLabel = 'Content ratings - Grid';

    protected string|Closure|null $preview = 'content-ratings.grid';
}
