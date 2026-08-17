<?php

declare(strict_types=1);

namespace Nova\Ranks\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Nova\Foundation\Enums\BasicStatus;

/**
 * @method static static from(string $base_image, ?string $overlay_image, ?int $group_id, ?int $name_id, BasicStatus $status)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class RankItemData extends Bag
{
    public function __construct(
        public string $base_image,
        public ?string $overlay_image,
        public ?int $group_id,
        public ?int $name_id,
        public BasicStatus $status
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'base_image' => $request->input('base_image'),
            'overlay_image' => $request->input('overlay_image'),
            'group_id' => $request->integer('group_id', null),
            'name_id' => $request->integer('name_id', null),
            'status' => BasicStatus::tryFrom($request->boolean('status') ? 'active' : 'inactive'),
        ];
    }
}
