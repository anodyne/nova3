<?php

declare(strict_types=1);

namespace Nova\Characters\Data;

use Bag\Attributes\StripExtraParameters;
use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

/**
 * @method static static from(?array $positions)
 */
#[StripExtraParameters]
readonly class AssignCharacterPositionsData extends Bag
{
    public function __construct(
        public ?array $positions
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'positions' => array_map('trim', explode(',', $request->input('assigned_positions') ?? '')),
        ];
    }
}
