<?php

declare(strict_types=1);

namespace Nova\Departments\Data;

use Illuminate\Http\Request;
use Nova\Departments\Models\Department;
use Spatie\LaravelData\Data;

class PositionData extends Data
{
    public function __construct(
        public string $name,
        public ?string $description,
        public ?int $available = 0,
        public ?bool $active = true,
        public ?Department $department,
        public int $department_id = 0
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            active: (bool) $request->input('active', true),
            available: (int) $request->available,
            department: Department::find($request->department_id),
            department_id: (int) $request->department_id,
            description: $request->description,
            name: $request->name,
        );
    }
}
