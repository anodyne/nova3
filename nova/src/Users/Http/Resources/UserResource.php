<?php

namespace Nova\Users\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'can' => [
                'delete' => gate()->allows('delete', $this->resource),
                'update' => gate()->allows('update', $this->resource),
            ],
            'avatar_url' => $this->avatar_url,
            'email' => $this->email,
            'id' => $this->id,
            'nickname' => $this->nickname,
            'roles' => $this->whenLoaded('roles'),
        ];
    }
}
