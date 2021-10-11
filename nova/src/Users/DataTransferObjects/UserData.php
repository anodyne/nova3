<?php

declare(strict_types=1);

namespace Nova\Users\DataTransferObjects;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Nova\Roles\Models\Role;
use Spatie\DataTransferObject\DataTransferObject;

class UserData extends DataTransferObject
{
    public string $name;

    public string $email;

    public PronounsData $pronouns;

    public ?Collection $roles;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'pronouns' => PronounsData::fromValue($request->input('pronouns', [])),
            'roles' => Role::whereIn('id', $request->input('roles', []))->get(),
        ]);
    }
}
