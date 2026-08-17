<?php

declare(strict_types=1);

namespace Nova\Roles\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

/**
 * @method static static from(?array $permissions)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class RolePermissionsData extends Bag
{
    public function __construct(
        public ?array $permissions
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'permissions' => $request->array('assigned_permissions'),
        ];
    }
}
