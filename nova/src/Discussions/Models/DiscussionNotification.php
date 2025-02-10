<?php

declare(strict_types=1);

namespace Nova\Discussions\Models;

use Nova\Discussions\Models\Builders\DiscussionNotificationBuilder;
use Nova\Foundation\Models\Model;

class DiscussionNotification extends Model
{
    protected $fillable = ['discussion_id', 'discussion_message_id', 'is_seen', 'is_sender', 'user_id'];

    public function newEloquentBuilder($query): DiscussionNotificationBuilder
    {
        return new DiscussionNotificationBuilder($query);
    }
}
