<?php

namespace Nova\Roles\Http\Resources;

use Nova\Users\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'permissions' => $this->whenLoaded('permissions'),
            'can' => [
                'create' => gate()->allows('create', $this->resource),
                'delete' => gate()->allows('delete', $this->resource),
                'duplicate' => gate()->allows('duplicate', $this->resource),
                'update' => gate()->allows('update', $this->resource),
                'view' => gate()->allows('view', $this->resource),
            ],
            'id' => $this->id,
            'name' => $this->name,
            'locked' => (bool) $this->locked,
            'display_name' => $this->display_name,
            'users' => UserResource::collection($this->whenLoaded('users')),
            'usersCount' => ($this->users_count) ?? $this->users()->count(),
        ];
    }
}
