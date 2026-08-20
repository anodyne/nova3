<?php

declare(strict_types=1);

namespace Nova\Discussions\Models;

use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Nova\Discussions\Models\Builders\DiscussionNotificationBuilder;
use Nova\Foundation\Models\Model;

/**
 * @mixin IdeHelperDiscussionNotification
 */
#[UseEloquentBuilder(DiscussionNotificationBuilder::class)]
class DiscussionNotification extends Model
{
    protected $fillable = [
        'discussion_id',
        'discussion_message_id',
        'is_seen',
        'is_sender',
        'user_id',
    ];
}
