<?php

declare(strict_types=1);

namespace Nova\PostTypes\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Spatie\LaravelData\Data;

class Options extends Data implements Arrayable
{
    public function __construct(
        public bool $notifyUsers,
        public bool $includeInPostTracking,
        public bool $multipleAuthors,
        public bool $allowCharacterAuthors,
        public bool $allowUserAuthors,
    ) {
    }

    public static function fromArray(array $array): static
    {
        return new self(
            notifyUsers: Arr::boolean($array, 'notifyUsers'),
            includeInPostTracking: Arr::boolean($array, 'includeInPostTracking'),
            multipleAuthors: Arr::boolean($array, 'multipleAuthors'),
            allowCharacterAuthors: Arr::boolean($array, 'allowCharacterAuthors'),
            allowUserAuthors: Arr::boolean($array, 'allowUserAuthors'),
        );
    }
}
