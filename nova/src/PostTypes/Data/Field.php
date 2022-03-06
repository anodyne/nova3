<?php

declare(strict_types=1);

namespace Nova\PostTypes\Data;

use Illuminate\Contracts\Support\Arrayable;
use Spatie\LaravelData\Data;

class Field extends Data implements Arrayable
{
    public function __construct(
        public bool $enabled,
        public bool $validate,
    ) {
    }

    public static function fromArray(array $array): static
    {
        return new self(
            enabled: (bool) data_get($array, 'enabled'),
            validate: (bool) data_get($array, 'validate'),
        );
    }
}