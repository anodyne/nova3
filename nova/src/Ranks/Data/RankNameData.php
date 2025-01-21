<?php

declare(strict_types=1);

namespace Nova\Ranks\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Nova\Ranks\Enums\RankNameStatus;

readonly class RankNameData extends Bag
{
    public function __construct(
        public string $name,
        public RankNameStatus $status
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'name' => $request->input('name'),
            'status' => RankNameStatus::tryFrom($request->input('status')) ?? RankNameStatus::Active,
        ];
    }
}
