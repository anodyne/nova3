<?php

namespace Nova\Users\DataTransferObjects;

use Nova\Roles\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;

class UserData extends DataTransferObject
{
    public string $name;

    public string $email;

    public string $pronouns;

    public ?Collection $roles;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'pronouns' => $request->input('pronouns'),
            'roles' => Role::whereIn('id', $request->input('roles', []))->get(),
        ]);
    }
}
