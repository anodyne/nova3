<?php

declare(strict_types=1);

namespace Nova\Departments\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Nova\Foundation\Enums\BasicStatus;

/**
 * @method static static from(string $name, ?string $description, string $department_id = null, int $available = 1, list<string> $tags = [], BasicStatus $status = BasicStatus::Active)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class PositionData extends Bag
{
    /** @param list<string> $tags */
    public function __construct(
        public string $name,
        public ?string $description,
        public string $department_id,
        public int $available = 1,
        public array $tags = [],
        public BasicStatus $status = BasicStatus::Active
    ) {}

    /**
     * @return array{
     *     name: mixed,
     *     description: mixed,
     *     department_id: string,
     *     available: int,
     *     tags: list<string>,
     *     status: BasicStatus|null
     * }
     */
    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'department_id' => $request->input('department_id'),
            'available' => $request->integer('available'),
            'tags' => array_map(trim(...), explode(',', $request->input('tags') ?? '')),
            'status' => BasicStatus::tryFrom($request->boolean('status') ? 'active' : 'inactive'),
        ];
    }
}
