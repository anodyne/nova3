<?php

declare(strict_types=1);

namespace Nova\Users\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

/**
 * @method static static from(?array $characters, ?int $primaryCharacter)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class AssignUserCharactersData extends Bag
{
    public function __construct(
        public ?array $characters,
        public ?int $primaryCharacter
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'characters' => explode(',', $request->input('assigned_characters', '') ?? ''),
            'primaryCharacter' => $request->integer('primary_character', null),
        ];
    }
}
