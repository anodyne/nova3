<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Bag\Attributes\StripExtraParameters;
use Bag\Bag;
use Illuminate\Database\Eloquent\Collection;

/**
 * @method static static from(array $characters, ?Collection $originalCharacters, array $users, ?Collection $originalUsers)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
#[StripExtraParameters]
readonly class PostAuthorsData extends Bag
{
    public function __construct(
        public array $characters = [],
        public ?Collection $originalCharacters = null,
        public array $users = [],
        public ?Collection $originalUsers = null
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
