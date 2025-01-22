<?php

declare(strict_types=1);

namespace Nova\Ranks\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Nova\Foundation\Enums\BasicStatus;

readonly class RankGroupData extends Bag
{
    public function __construct(
        public string $name,
        public BasicStatus $status,
        public ?string $base_image
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'name' => $request->input('name'),
            'status' => BasicStatus::tryFrom($request->input('status')) ?? BasicStatus::Active,
            'base_image' => $request->input('base_image'),
        ];
    }
}
