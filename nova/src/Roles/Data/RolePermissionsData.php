<?php

declare(strict_types=1);

namespace Nova\Roles\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

/**
 * @method static static from(?array $permissions)
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
            'permissions' => collect(explode(',', $request->input('assigned_permissions') ?? ''))->filter()->all(),
        ];
    }
}
