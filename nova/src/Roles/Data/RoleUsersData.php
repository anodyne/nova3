<?php

declare(strict_types=1);

namespace Nova\Roles\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

readonly class RoleUsersData extends Bag
{
    public function __construct(
        public ?array $users
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'users' => collect(explode(',', $request->input('assigned_users') ?? ''))->filter()->all(),
        ];
    }
}
