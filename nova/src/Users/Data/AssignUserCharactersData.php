<?php

declare(strict_types=1);

namespace Nova\Users\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

/**
 * @method static static from(list<string> $characters, ?string $primaryCharacter)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class AssignUserCharactersData extends Bag
{
    /** @param list<string> $characters */
    public function __construct(
        public array $characters,
        public ?string $primaryCharacter
    ) {}

    /** @return array{characters: list<string>, primaryCharacter: string|null} */
    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'characters' => explode(',', $request->input('assigned_characters', '') ?? ''),
            'primaryCharacter' => $request->filled('primary_character') ? $request->input('primary_character') : null,
        ];
    }
}
