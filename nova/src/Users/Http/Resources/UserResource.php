<?php

namespace Nova\Users\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        $user = auth()->user();

        return [
            'can' => [
                'delete' => $user->can('user.delete') && $this->id !== $user->id,
                'update' => $user->can('user.update'),
            ],
            'email' => $this->email,
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
