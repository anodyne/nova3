<?php

namespace Nova\Users\Http\Resources;

use Nova\Users\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    public $collects = UserResource::class;

    public function toArray($request)
    {
        return [
            'can' => [
                'create' => gate()->allows('create', User::class),
            ],
            'data' => $this->collection,
        ];
    }
}
