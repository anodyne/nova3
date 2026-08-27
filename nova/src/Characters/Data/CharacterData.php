<?php

declare(strict_types=1);

namespace Nova\Characters\Data;

use Bag\Attributes\StripExtraParameters;
use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

/**
 * @method static static from(string $name, ?string $rank_id)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
#[StripExtraParameters]
readonly class CharacterData extends Bag
{
    public function __construct(
        public string $name,
        public ?string $rank_id
    ) {}

    /**
     * @return array{name: mixed, rank_id: mixed|null}
     */
    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'name' => $request->input('name'),
            'rank_id' => $request->filled('rank_id') ? $request->input('rank_id') : null,
        ];
    }
}
