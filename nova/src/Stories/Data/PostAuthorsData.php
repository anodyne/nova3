<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Bag\Attributes\StripExtraParameters;
use Bag\Bag;
use Illuminate\Support\Collection;

/**
 * @method static static from(?Collection $characters, ?Collection $users)
 */
#[StripExtraParameters]
readonly class PostAuthorsData extends Bag
{
    public function __construct(
        public ?Collection $characters,
        public ?Collection $users,
    ) {}
}
