<?php

declare(strict_types=1);

namespace Nova\PostTypes\Data;

use Illuminate\Contracts\Support\Arrayable;
use Spatie\LaravelData\Data;

class Options extends Data implements Arrayable
{
    public function __construct(
        public bool $notifyUsers,
        public bool $notifyDiscord,
        public bool $includeInPostTracking,
        public bool $multipleAuthors,
    ) {
    }

    public static function fromArray(array $array): static
    {
        return new self(
            notifyUsers: (bool) data_get($array, 'notifyUsers'),
            notifyDiscord: (bool) data_get($array, 'notifyDiscord'),
            includeInPostTracking: (bool) data_get($array, 'includeInPostTracking'),
            multipleAuthors: (bool) data_get($array, 'multipleAuthors'),
        );
    }
}
