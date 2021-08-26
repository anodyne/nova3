<?php

declare(strict_types=1);

namespace Nova\PostTypes\Values;

use Illuminate\Contracts\Support\Arrayable;
use Spatie\DataTransferObject\DataTransferObject;

class Field extends DataTransferObject implements Arrayable
{
    public bool $enabled;

    public bool $validate;

    public bool $suggest;

    public static function fromArray(array $array): self
    {
        return new self([
            'enabled' => (bool) data_get($array, 'enabled'),
            'validate' => (bool) data_get($array, 'validate'),
            'suggest' => (bool) data_get($array, 'suggest'),
        ]);
    }
}
