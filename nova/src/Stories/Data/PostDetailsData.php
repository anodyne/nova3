<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Bag\Attributes\StripExtraParameters;
use Bag\Bag;

/**
 * @method static static from(?string $content, ?string $title, ?string $day, ?string $time, ?string $location)
 */
#[StripExtraParameters]
readonly class PostDetailsData extends Bag
{
    public function __construct(
        public ?string $content,
        public ?string $title,
        public ?string $day,
        public ?string $time,
        public ?string $location,
    ) {}
}
