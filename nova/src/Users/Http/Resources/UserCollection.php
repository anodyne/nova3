<?php

namespace Nova\Users\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    public $collects = UserResource::class;

    public function toArray($request)
    {
        return [
            'can' => [
                'create' => auth()->user()->can('user.create')
            ],
            'data' => $this->collection,
        ];
    }
}
