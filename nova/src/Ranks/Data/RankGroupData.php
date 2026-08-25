<?php

declare(strict_types=1);

namespace Nova\Ranks\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Nova\Foundation\Enums\BasicStatus;

/**
 * @method static static from(string $name, BasicStatus $status, ?string $base_image)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class RankGroupData extends Bag
{
    public function __construct(
        public string $name,
        public BasicStatus $status,
        public ?string $base_image
    ) {}

    /**
     * @return array{
     *      name: mixed,
     *      status: ?BasicStatus,
     *      base_image: mixed
     * }
     */
    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'name' => $request->input('name'),
            'status' => BasicStatus::tryFrom($request->boolean('status') ? 'active' : 'inactive'),
            'base_image' => $request->input('base_image'),
        ];
    }
}
