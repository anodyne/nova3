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
        public ?string $status
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            name: $request->input('name'),
            description: $request->input('description'),
            status: $request->input('status', 'active'),
        );
    }
}
