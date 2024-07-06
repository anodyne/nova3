<?php

declare(strict_types=1);

namespace Nova\Users\Data;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class AssignUserRolesData extends Data
{
    public function __construct(
        public ?array $roles
    ) {}

    public static function fromRequest(Request $request): static
    {
        return new self(
            roles: explode(',', $request->input('assigned_roles', '') ?? ''),
        );
    }
}
