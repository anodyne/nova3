<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Bag\Attributes\StripExtraParameters;
use Bag\Bag;

/**
 * @method static static from(?string $summary)
 */
#[StripExtraParameters]
readonly class PostSummaryData extends Bag
{
    public function __construct(
        public ?string $summary
    ) {}
}
