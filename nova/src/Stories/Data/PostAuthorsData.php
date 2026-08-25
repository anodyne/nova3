<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Bag\Attributes\StripExtraParameters;
use Bag\Bag;
use Illuminate\Database\Eloquent\Collection;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

/**
 * @method static static from(array $characters, ?Collection<int, Character> $originalCharacters, array $users, ?Collection<int, User> $originalUsers)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
#[StripExtraParameters]
readonly class PostAuthorsData extends Bag
{
    /**
     * @param  Collection<int, Character>|null  $originalCharacters
     * @param  Collection<int, User>|null  $originalUsers
     * @param  array<int|string, mixed>  $characters
     * @param  array<int|string, mixed>  $users
     */
    public function __construct(
        public array $characters = [],
        public ?Collection $originalCharacters = null,
        public array $users = [],
        public ?Collection $originalUsers = null
    ) {}

    /** @return list<int> */
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
