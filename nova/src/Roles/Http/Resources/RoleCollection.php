<?php

namespace Nova\Roles\Http\Resources;

use Nova\Roles\Models\Role;
use Nova\Foundation\Http\Resources\ResourceCollection;

class RoleCollection extends ResourceCollection
{
    public $collects = RoleResource::class;

    public function toArray($request)
    {
        return $this->paginateResources([
            'can' => [
                'create' => gate()->allows('create', Role::class),
            ],
        ]);
    }
}
