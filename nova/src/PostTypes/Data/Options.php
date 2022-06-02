<?php

declare(strict_types=1);

namespace Nova\PostTypes\Data;

use Illuminate\Contracts\Support\Arrayable;
use Spatie\LaravelData\Data;

class Options extends Data implements Arrayable
{
    public function __construct(
        public bool $notifyUsers,
        public bool $includeInPostTracking,
        public bool $multipleAuthors,
    ) {
    }

    public static function fromArray(array $array): static
    {
        return new self(
            notifyUsers: filter_var(data_get($array, 'notifyUsers'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
            includeInPostTracking: filter_var(data_get($array, 'includeInPostTracking'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
            multipleAuthors: filter_var(data_get($array, 'multipleAuthors'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
        );
    }
}
