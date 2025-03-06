<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Bag\Attributes\StripExtraParameters;
use Bag\Bag;

/**
 * @method static static from(array $characters, array $users)
 */
#[StripExtraParameters]
readonly class PostAuthorsData extends Bag
{
    public function __construct(
        public array $characters = [],
        public array $users = [],
    ) {}

    public function getUserIds(): array
    {
        return collect(array_keys($this->users))
            ->merge(array_column($this->characters, 'user_id'))
            ->filter()
            ->unique()
            ->values()
            ->toArray();
    }
}
