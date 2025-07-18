<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\ContentRatings;

use Closure;

class CardsContentRatingsBlock extends ContentRatingsBlock
{
    const component = 'content-ratings.cards';

    protected ?string $blockLabel = 'Content ratings - Cards';

    protected string|Closure|null $preview = 'content-ratings.cards';
}
