<?php

declare(strict_types=1);

namespace Nova\Departments\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Nova\Foundation\Enums\BasicStatus;

/**
 * @method static static from(string $name, ?string $description, int $available, list<string> $tags, BasicStatus $status, int $department_id)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class PositionData extends Bag
{
    /** @param list<string> $tags */
    public function __construct(
        public string $name,
        public ?string $description,
        public int $available,
        public array $tags,
        public BasicStatus $status,
        public int $department_id = 0
    ) {}

    /**
     * @return array{
     *     name: mixed,
     *     description: mixed,
     *     available: int,
     *     tags: list<string>,
     *     status: BasicStatus|null,
     *     department_id: int
     * }
     */
    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'available' => $request->integer('available'),
            'tags' => array_map(trim(...), explode(',', $request->input('tags') ?? '')),
            'status' => BasicStatus::tryFrom($request->boolean('status') ? 'active' : 'inactive'),
            'department_id' => $request->integer('department_id'),
        ];
    }
}
