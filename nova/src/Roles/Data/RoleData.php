<?php

declare(strict_types=1);

namespace Nova\Roles\Data;

use Bag\Attributes\MapInputName;
use Bag\Attributes\MapOutputName;
use Bag\Attributes\Transforms;
use Bag\Bag;
use Bag\Mappers\SnakeCase;
use Illuminate\Http\Request;

/**
 * @method static static from(string $name, string $displayName, ?string $description, bool $isDefault)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
#[MapInputName(SnakeCase::class)]
#[MapOutputName(SnakeCase::class)]
readonly class RoleData extends Bag
{
    public function __construct(
        public string $name,
        public string $displayName,
        public ?string $description,
        public bool $isDefault = false,
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'name' => $request->input('name'),
            'displayName' => $request->input('display_name'),
            'description' => $request->input('description'),
            'isDefault' => $request->boolean('is_default', false),
        ];
    }
}
