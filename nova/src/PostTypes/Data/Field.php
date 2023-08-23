<?php

declare(strict_types=1);

namespace Nova\PostTypes\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Nova\Foundation\Rules\Boolean;
use Spatie\LaravelData\Data;

class Field extends Data implements Arrayable
{
    public function __construct(
        public bool $enabled,
        public bool $required,
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new self(
            enabled: Arr::boolean($data, 'enabled'),
            required: Arr::boolean($data, 'required')
        );
    }

    public static function rules(): array
    {
        return [
            'enabled' => [new Boolean()],
            'required' => [new Boolean()],
        ];
    }
}
