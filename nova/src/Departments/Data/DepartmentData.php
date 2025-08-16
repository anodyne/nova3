<?php

declare(strict_types=1);

namespace Nova\Departments\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Nova\Foundation\Enums\BasicStatus;

/**
 * @method static static from(string $name, ?string $description, array $tags, BasicStatus $status)
 */
readonly class DepartmentData extends Bag
{
    public function __construct(
        public string $name,
        public ?string $description,
        public array $tags,
        public BasicStatus $status,
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'tags' => array_map('trim', explode(',', $request->input('tags') ?? '')),
            'status' => BasicStatus::tryFrom($request->boolean('status') ? 'active' : 'inactive'),
        ];
    }
}
