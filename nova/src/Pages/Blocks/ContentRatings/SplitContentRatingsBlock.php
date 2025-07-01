<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\ContentRatings;

use Closure;

class SplitContentRatingsBlock extends ContentRatingsBlock
{
    const component = 'content-ratings.split';

    protected ?string $blockLabel = 'Content ratings - Split';

    protected string|Closure|null $preview = 'content-ratings.split';

    public function blockSchema(): array
    {
        return [];
    }
}
