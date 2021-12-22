<?php

declare(strict_types=1);

namespace Nova\Roles\Data;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Nova\Roles\Models\Permission;
use Spatie\LaravelData\Data;

class RoleData extends Data
{
    public function __construct(
        public string $name,
        public string $display_name,
        public ?string $description,
        public ?Collection $permissions,
        public bool $default,
        public ?array $users,
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            default: (bool) $request->input('default', false),
            description: $request->input('description'),
            display_name: $request->input('display_name'),
            name: $request->input('name'),
            permissions: Permission::whereIn('id', $request->input('permissions', []))->get(),
            users: $request->input('users'),
        );
    }
}
