<?php

declare(strict_types=1);

namespace Nova\Ranks\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Nova\Foundation\Enums\BasicStatus;

/**
 * @method static static from(string $base_image, ?string $overlay_image, ?string $group_id, ?string $name_id, BasicStatus $status = BasicStatus::Active)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class RankItemData extends Bag
{
    public function __construct(
        public string $base_image,
        public ?string $overlay_image,
        public ?string $group_id,
        public ?string $name_id,
        public BasicStatus $status = BasicStatus::Active
    ) {}

    /**
     * @return array{
     *      base_image: string,
     *      overlay_image: string|null,
     *      group_id: string|null,
     *      name_id: string|null,
     *      status: ?BasicStatus
     * }
     */
    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'base_image' => $request->input('base_image'),
            'overlay_image' => $request->input('overlay_image'),
            'group_id' => $request->input('group_id'),
            'name_id' => $request->input('name_id'),
            'status' => BasicStatus::tryFrom($request->boolean('status') ? 'active' : 'inactive'),
        ];
    }
}
