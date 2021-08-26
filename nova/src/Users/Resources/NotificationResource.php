<?php

declare(strict_types=1);

namespace Nova\Users\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'data' => $this->data,
            'date' => $this->created_at->diffForHumans(),
            'type' => strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', get_class_name($this->type))),
            'unread' => $this->read_at === null,
        ];
    }
}
