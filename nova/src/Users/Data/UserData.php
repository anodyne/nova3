<?php

declare(strict_types=1);

namespace Nova\Users\Data;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Nova\Roles\Models\Role;
use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public PronounsData $pronouns,
        public ?Collection $roles,
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            email: $request->input('email'),
            name: $request->input('name'),
            pronouns: PronounsData::from($request->input('pronouns', [])),
            roles: Role::whereIn('id', $request->input('roles', []))->get(),
        );
    }
}
