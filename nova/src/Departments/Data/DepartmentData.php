<?php

declare(strict_types=1);

namespace Nova\Departments\Data;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class DepartmentData extends Data
{
    public function __construct(
        public string $name,
        public ?string $description,
        public bool $active = true
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            active: (bool) ($request->active ?? true),
            description: $request->description,
            name: $request->name,
        );
    }
}
