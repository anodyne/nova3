<?php

declare(strict_types=1);

namespace Nova\Ranks\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Nova\Ranks\Enums\RankItemStatus;

readonly class RankItemData extends Bag
{
    public function __construct(
        public string $base_image,
        public ?string $overlay_image,
        public ?int $group_id,
        public ?int $name_id,
        public RankItemStatus $status
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'base_image' => $request->input('base_image'),
            'overlay_image' => $request->input('overlay_image'),
            'group_id' => $request->integer('group_id'),
            'name_id' => $request->integer('name_id'),
            'status' => RankItemStatus::tryFrom($request->input('status')) ?? RankItemStatus::Active,
        ];
    }
}
