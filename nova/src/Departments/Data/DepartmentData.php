<?php

declare(strict_types=1);

namespace Nova\Departments\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Nova\Departments\Enums\DepartmentStatus;

readonly class DepartmentData extends Bag
{
    public function __construct(
        public string $name,
        public ?string $description,
        public array $tags,
        public DepartmentStatus $status,
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'tags' => array_map('trim', explode(',', $request->input('tags', ''))),
            'status' => DepartmentStatus::tryFrom($request->input('status')) ?? DepartmentStatus::Active,
        ];
    }
}
