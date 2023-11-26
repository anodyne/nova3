<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Illuminate\Support\Collection;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;
use Spatie\LaravelData\Data;

class PostAuthorsData extends Data
{
    public function __construct(
        public ?Collection $characters,
        public ?Collection $users,
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new self(
            characters: Character::query()->whereIn('id', data_get($data, 'characters'))->get(),
            users: User::query()->whereIn('id', data_get($data, 'users'))->get(),
        );
    }
}
