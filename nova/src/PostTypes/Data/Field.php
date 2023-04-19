<?php

declare(strict_types=1);

namespace Nova\PostTypes\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
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
            enabled: Arr::boolean($array, 'enabled'),
            required: Arr::boolean($array, 'required'),
        );
    }
}
