<?php

declare(strict_types=1);

namespace Nova\Characters\Data;

use Bag\Attributes\StripExtraParameters;
use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

#[StripExtraParameters]
readonly class AssignCharacterOwnersData extends Bag
{
    public function __construct(
        public ?array $users,
        public ?array $primaryUsers
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'users' => array_map('trim', explode(',', $request->input('assigned_users') ?? '')),
            'primaryUsers' => array_map('trim', explode(',', $request->input('primary_users') ?? '')),
        ];
    }
}
