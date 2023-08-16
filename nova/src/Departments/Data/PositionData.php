<?php

declare(strict_types=1);

namespace Nova\Departments\Data;

use Illuminate\Http\Request;
use Nova\Departments\Enums\PositionStatus;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Data;

class PositionData extends Data
{
    public function __construct(
        public string $name,
        public ?string $description,
        public ?int $available,
        #[Enum(PositionStatus::class)]
        public ?PositionStatus $status,
        public int $department_id = 0
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new self(
            name: data_get($data, 'name'),
            description: data_get($data, 'description'),
            available: data_get($data, 'available'),
            status: PositionStatus::tryFrom(data_get($data, 'status', PositionStatus::active->value)),
            department_id: data_get($data, 'department_id', 0),
        );
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            name: $request->input('name'),
            description: $request->input('description'),
            available: $request->integer('available'),
            status: PositionStatus::tryFrom($request->input('status', PositionStatus::active->value)),
            department_id: $request->integer('department_id'),
        );
    }
}
