<?php

namespace Nova\Users\Http\Resources;

use Nova\Roles\Models\Role;
use Nova\Roles\Http\Resources\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'can' => [
                'delete' => gate()->allows('delete', $this->resource),
                'update' => gate()->allows('update', $this->resource),
                'view' => gate()->allows('view', $this->resource),
                'manageRoles' => gate()->allows('viewAny', Role::class),
            ],
            'avatar_url' => $this->avatar_url,
            'has_avatar' => $this->has_avatar,
            'email' => $this->email,
            'gender' => $this->gender,
            'lastLogin' => $this->present()->lastLogin,
            'lastLoginSimple' => optional($this->last_login)->format('Y-m-d'),
            'pronouns' => $this->pronouns,
            'id' => $this->id,
            'name' => $this->name,
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
        ];
    }
}
