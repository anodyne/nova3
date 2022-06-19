<?php

declare(strict_types=1);

namespace Nova\PostTypes\Data;

use Illuminate\Contracts\Support\Arrayable;
use Spatie\LaravelData\Data;

class Field extends Data implements Arrayable
{
    public function __construct(
        public bool $enabled,
        public bool $required,
    ) {
    }

    public static function fromArray(array $array): static
    {
        return new self(
            enabled: filter_var(data_get($array, 'enabled'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
            required: filter_var(data_get($array, 'required'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
        );
    }
}
