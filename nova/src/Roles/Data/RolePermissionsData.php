<?php

declare(strict_types=1);

namespace Nova\Roles\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

/**
 * @method static static from(?array<int, mixed> $permissions)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class RolePermissionsData extends Bag
{
    /** @param array<int, mixed>|null $permissions */
    public function __construct(
        public ?array $permissions
    ) {}

    /** @return array{permissions: array<int, mixed>} */
    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'permissions' => $request->array('assigned_permissions'),
        ];
    }
}
