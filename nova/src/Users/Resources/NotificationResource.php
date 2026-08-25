<?php

declare(strict_types=1);

namespace Nova\Users\Resources;

use Carbon\CarbonInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Notifications\DatabaseNotification;

/**
 * @mixin DatabaseNotification
 *
 * @property-read CarbonInterface|null $created_at
 */
class NotificationResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'data' => $this->data,
            'date' => $this->created_at,
            'type' => strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', get_class_name($this->type))),
            'unread' => $this->read_at === null,
        ];
    }
}
