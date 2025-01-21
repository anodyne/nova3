<?php

declare(strict_types=1);

namespace Nova\Departments\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Nova\Departments\Enums\PositionStatus;

readonly class PositionData extends Bag
{
    public function __construct(
        public string $name,
        public ?string $description,
        public int $available,
        public array $tags,
        public PositionStatus $status,
        public int $department_id = 0
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'available' => $request->integer('available'),
            'tags' => array_map('trim', explode(',', $request->input('tags', ''))),
            'status' => PositionStatus::tryFrom($request->input('status')) ?? PositionStatus::Active,
            'department_id' => $request->integer('department_id'),
        ];
    }
}
