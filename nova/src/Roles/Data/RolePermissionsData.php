<?php

declare(strict_types=1);

namespace Nova\Roles\Data;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class RolePermissionsData extends Data
{
    public function __construct(
        public ?array $permissions
    ) {}

    public static function fromRequest(Request $request): static
    {
        return new self(
            permissions: collect(explode(',', $request->input('assigned_permissions') ?? ''))->filter()->all()
        );
    }
}
