<?php

namespace Nova\Roles\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'abilities' => $this->getAbilities(),
            'can' => [
                'create' => gate()->allows('create', $this->resource),
                'delete' => gate()->allows('delete', $this->resource),
                'update' => gate()->allows('update', $this->resource),
            ],
            'id' => $this->id,
            'name' => $this->name,
            'locked' => (bool) $this->locked,
            'title' => $this->title,
        ];
    }
}
