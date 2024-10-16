<?php

declare(strict_types=1);

namespace Nova\Departments\Data;

use Illuminate\Http\Request;
use Nova\Departments\Enums\DepartmentStatus;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Data;

class DepartmentData extends Data
{
    public function __construct(
        public string $name,

        public ?string $description,

        #[Enum(DepartmentStatus::class)]
        public ?DepartmentStatus $status
    ) {}

    public static function fromArray(array $data): static
    {
        return new self(
            name: data_get($data, 'name'),
            description: data_get($data, 'description'),
            status: DepartmentStatus::tryFrom(data_get($data, 'status', DepartmentStatus::active->value)),
        );
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            name: $request->input('name'),
            description: $request->input('description'),
            status: DepartmentStatus::tryFrom($request->input('status', DepartmentStatus::active->value)),
        );
    }
}
