<?php

namespace Nova\Roles\Http\Resources;

use Nova\Roles\Models\Role;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleCollection extends ResourceCollection
{
    public $collects = RoleResource::class;

    public function toArray($request)
    {
        return [
            'can' => [
                'create' => gate()->allows('create', Role::class),
            ],
            'data' => $this->collection,
        ];
    }
}
