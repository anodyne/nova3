<?php

declare(strict_types=1);

namespace Nova\Roles\Data;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class RoleData extends Data
{
    public function __construct(
        public string $name,
        public string $display_name,
        public ?string $description,
        public bool $default,
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            default: $request->boolean('default', false),
            description: $request->input('description'),
            display_name: $request->input('display_name'),
            name: $request->input('name'),
        );
    }
}
