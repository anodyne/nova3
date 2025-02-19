<?php

declare(strict_types=1);

namespace Nova\Characters\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

/**
 * @method static static from(string $name, ?int $rank_id)
 */
readonly class CharacterData extends Bag
{
    public function __construct(
        public string $name,
        public ?int $rank_id
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'name' => $request->input('name'),
            'rank_id' => $request->integer('rank_id', null),
        ];
    }
}
