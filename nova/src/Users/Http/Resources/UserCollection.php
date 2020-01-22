<?php

namespace Nova\Users\Http\Resources;

use Nova\Users\Models\User;
use Nova\Foundation\Http\Resources\ResourceCollection;

class UserCollection extends ResourceCollection
{
    public $collects = UserResource::class;

    public function toArray($request)
    {
        return $this->paginateResources([
            'can' => [
                'create' => gate()->allows('create', User::class),
            ],
        ]);
    }
}
