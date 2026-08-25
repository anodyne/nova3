<?php

declare(strict_types=1);

namespace Nova\Characters\Data;

use Bag\Attributes\StripExtraParameters;
use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

/**
 * @method static static from(list<int|string>|null $positions)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
#[StripExtraParameters]
readonly class AssignCharacterPositionsData extends Bag
{
    /** @param list<int|string>|null $positions */
    public function __construct(
        public ?array $positions
    ) {}

    /**
     * @return array{positions: list<string>}
     */
    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'positions' => array_map(trim(...), explode(',', $request->input('assigned_positions') ?? '')),
        ];
    }
}
