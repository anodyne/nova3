<?php

declare(strict_types=1);

namespace Nova\Forms\Data;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class FormData extends Data
{
    public function __construct(
        public string $name,
        public string $key,
        public ?string $description,
        public bool $locked,
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            locked: false,
            description: $request->input('description'),
            key: $request->input('key'),
            name: $request->input('name'),
        );
    }
}
