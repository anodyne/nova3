<?php

declare(strict_types=1);

namespace Nova\Users\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

/**
 * @method static static from(list<string> $roles)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class AssignUserRolesData extends Bag
{
    /** @param list<string> $roles */
    public function __construct(
        public array $roles
    ) {}

    /** @return array{roles: list<string>} */
    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'roles' => explode(',', $request->input('assigned_roles', '') ?? ''),
        ];
    }
}
