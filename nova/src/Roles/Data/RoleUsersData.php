<?php

declare(strict_types=1);

namespace Nova\Roles\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

/**
 * @method static static from(?array<int, string> $users)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class RoleUsersData extends Bag
{
    /** @param array<int, string>|null $users */
    public function __construct(
        public ?array $users
    ) {}

    /** @return array{users: array<int, string>} */
    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'users' => collect(explode(',', $request->input('assigned_users') ?? ''))->filter()->all(),
        ];
    }
}
