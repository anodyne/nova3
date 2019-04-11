<?php

namespace Nova\Roles\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    public function toArray($request)
    {
        $user = auth()->user();

        return [
            'abilities' => $this->getAbilities(),
            'can' => [
                'create' => $user->can('role.create'),
                'delete' => $user->can('role.delete') && ! $this->locked,
                'update' => $user->can('role.update') && ! $this->locked,
            ],
            'id' => $this->id,
            'name' => $this->name,
            'locked' => (bool) $this->locked,
            'title' => $this->title,
        ];
    }
}
