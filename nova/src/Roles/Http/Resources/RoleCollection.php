<?php

namespace Nova\Roles\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleCollection extends ResourceCollection
{
    public $collects = RoleResource::class;

    public function toArray($request)
    {
        return [
            'can' => [
                'create' => auth()->user()->can('role.create'),
            ],
            'data' => $this->collection,
        ];
    }
}
