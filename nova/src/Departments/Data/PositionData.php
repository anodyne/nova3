<?php

declare(strict_types=1);

namespace Nova\Departments\Data;

use Illuminate\Http\Request;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\States\Positions\Active;
use Spatie\LaravelData\Data;

class PositionData extends Data
{
    public function __construct(
        public string $name,
        public ?string $description,
        public ?int $available,
        public ?string $status,
        public ?Department $department,
        public int $department_id = 0
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            available: (int) $request->input('available', 0),
            department: Department::find($request->input('department_id')),
            department_id: (int) $request->input('department_id', 0),
            description: $request->input('description'),
            name: $request->input('name'),
            status: $request->input('status', Active::class),
        );
    }
}
