<?php

declare(strict_types=1);

namespace Nova\Characters\Data;

use Bag\Attributes\StripExtraParameters;
use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

/**
 * @method static static from(list<int|string>|null $users, list<int|string>|null $primaryUsers)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
#[StripExtraParameters]
readonly class AssignCharacterOwnersData extends Bag
{
    /**
     * @param  list<int|string>|null  $users
     * @param  list<int|string>|null  $primaryUsers
     */
    public function __construct(
        public ?array $users,
        public ?array $primaryUsers
    ) {}

    /**
     * @return array{
     *     users: list<string>,
     *     primaryUsers: list<string>
     * }
     */
    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'users' => array_map(trim(...), explode(',', $request->input('assigned_users') ?? '')),
            'primaryUsers' => array_map(trim(...), explode(',', $request->input('primary_users') ?? '')),
        ];
    }
}
