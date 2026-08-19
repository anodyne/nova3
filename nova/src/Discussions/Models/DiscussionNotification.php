<?php

declare(strict_types=1);

namespace Nova\Discussions\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Nova\Discussions\Models\Builders\DiscussionNotificationBuilder;
use Nova\Foundation\Models\Model;

/**
 * @property int $id
 * @property int $discussion_id
 * @property int $discussion_message_id
 * @property int $user_id
 * @property int $is_seen
 * @property int $is_sender
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property string|null $deleted_at
 *
 * @method static DiscussionNotificationBuilder<static>|DiscussionNotification discussion(int $discussionId)
 * @method static DiscussionNotificationBuilder<static>|DiscussionNotification newModelQuery()
 * @method static DiscussionNotificationBuilder<static>|DiscussionNotification newQuery()
 * @method static DiscussionNotificationBuilder<static>|DiscussionNotification query()
 * @method static DiscussionNotificationBuilder<static>|DiscussionNotification unread()
 * @method static DiscussionNotificationBuilder<static>|DiscussionNotification user(int $userId)
 * @method static DiscussionNotificationBuilder<static>|DiscussionNotification whereCreatedAt($value)
 * @method static DiscussionNotificationBuilder<static>|DiscussionNotification whereDeletedAt($value)
 * @method static DiscussionNotificationBuilder<static>|DiscussionNotification whereDiscussionId($value)
 * @method static DiscussionNotificationBuilder<static>|DiscussionNotification whereDiscussionMessageId($value)
 * @method static DiscussionNotificationBuilder<static>|DiscussionNotification whereId($value)
 * @method static DiscussionNotificationBuilder<static>|DiscussionNotification whereIsSeen($value)
 * @method static DiscussionNotificationBuilder<static>|DiscussionNotification whereIsSender($value)
 * @method static DiscussionNotificationBuilder<static>|DiscussionNotification whereUpdatedAt($value)
 * @method static DiscussionNotificationBuilder<static>|DiscussionNotification whereUserId($value)
 *
 * @mixin \Eloquent
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
