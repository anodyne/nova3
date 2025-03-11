<?php

declare(strict_types=1);

namespace Nova\Users\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

/**
 * @method static static from(?array $roles)
 */
readonly class AssignUserRolesData extends Bag
{
    public function __construct(
        public ?array $roles
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'roles' => explode(',', $request->input('assigned_roles', '') ?? ''),
        ];
    }
}
