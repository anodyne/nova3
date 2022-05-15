<?php

declare(strict_types=1);

namespace Nova\Departments\Data;

use Illuminate\Http\Request;
use Nova\Departments\Models\States\Departments\Active;
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
            status: $request->input('status', Active::class),
            description: $request->description,
            name: $request->name,
        );
    }
}
